<?php

namespace flipbox\rest;

use Craft;
use craft\helpers\ArrayHelper;
use craft\elements\User;
use flipbox\guardian\behaviors\TokenBehavior;
use flipbox\guardian\helpers\Request as RequestHelper;
use flipbox\guardian\Guardian as GuardianPlugin;
use League\OAuth2\Server\Exception\OAuthServerException;
use yii\filters\auth\HttpBearerAuth;
use yii\web\HttpException;

class UserIdentity extends User
{

    // This is temporary...if the token matches the config, return a default user
    public static function findIdentityByAccessToken($token, $type = null)
    {

        if($type === HttpBearerAuth::class) {
            return static::authenticateViaBearerToken();
        }

        return null;

    }

    /**
     * Authenticate the incoming request via the Bearer token.
     *
     * @param  Request  $request
     * @return mixed
     */
    protected static function authenticateViaBearerToken()
    {

        $psrRequest = RequestHelper::toPsr(
            Craft::$app->getRequest()
        );

        // First, we will convert the Symfony request to a PSR-7 implementation which will
        // be compatible with the base OAuth2 library. The Symfony bridge can perform a
        // conversion for us to a Zend Diactoros implementation of the PSR-7 request.
//        $psr = (new DiactorosFactory)->createRequest($request);

        try {

            $psr = GuardianPlugin::getInstance()->getResourceServer()->validateAuthenticatedRequest($psrRequest);

            // If the access token is valid we will retrieve the user according to the user ID
            // associated with the token. We will use the provider implementation which may
            // be used to retrieve users from Eloquent. Next, we'll be ready to continue.
            $user = Craft::$app->getUsers()->getUserById($psr->getAttribute('oauth_user_id'));

            if (! $user) {
                return null;
            }

            // Next, we will assign a token instance to this user which the developers may use
            // to determine if the token has a given scope, etc. This will be useful during
            // authorization such as within the developer's Laravel model policy classes.
            $token = GuardianPlugin::getInstance()->getAccessToken()->findActive(
                $psr->getAttribute('oauth_access_token_id')
            );

            $user->attachBehavior(
                'guardian',
                [
                    'class' => TokenBehavior::class,
                    'token' => $token
                ]
            );

            $clientId = $psr->getAttribute('oauth_client_id');

            // Finally, we will verify if the client that issued this token is still valid and
            // its tokens may still be used. If not, we will bail out since we don't want a
            // user to be able to send access tokens for deleted or revoked applications.
            if (!GuardianPlugin::getInstance()->getClient()->find($clientId)) {
                return null;
            }

            return $user;

        } catch (OAuthServerException $e) {

            throw new HttpException($e->getHttpStatusCode(), $e->getMessage());

        }
    }

}
