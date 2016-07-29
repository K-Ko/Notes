<?php
/**
 *
 */
class BasicAuth
{

    /**
     * Validate given MD5 hashed credentials against HTTP basic auth
     *
     * @param string|array $user Basic auth user name or array of 'user' => MD5('password')
     */
    public static function validate(
        $user, $pass = null, $realm = 'Restricted area', $error = 'Login required'
    )
    {
        $auth_user = isset($_SERVER['PHP_AUTH_USER']) ? strtolower($_SERVER['PHP_AUTH_USER']) : null;
        $auth_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

        if (!is_array($user)) {
            $user = array($user => $pass);
        }

        foreach ($user as $name=>$pw) {
            if ($auth_user === strtolower($name) &&
                // Compare lowercase for safety
                strtolower(sha1($auth_pass)) === strtolower($pw)) {
                return $name;
            }
        }

        header('HTTP/1.0 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="'.$realm.'"');
        die($error);
    }

    /**
     * Validate given plain text credentials against HTTP basic auth
     *
     * @param string|array $user Basic auth user name or array of 'user' => 'password'
     */
    public static function validate_plain(
        $user, $pass = null, $realm = 'Restricted area', $error = 'Login required'
    )
    {
        if (!is_array($user)) {
            $user = array($user => $pass);
        }

        foreach ($user as $name=>$pw) {
            $user[$name] = sha1($pw);
        }

        return self::validate($user, $pass, $realm, $error);
    }

}
