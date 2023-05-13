<?php
namespace DaVinci\Auth;

use DaVinci\Models\User;
use DaVinci\Session\Session;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

use DateTimeImmutable;

require_once '../../vendor/autoload.php';

/**
 * Class Auth
 *
 * Administra lo relacionado a la autenticación:
 * - Autentica.
 * - Cierra sessión
 * - Verifica si estás autenticado.
 */
class AuthToken
{
    protected $id;
    protected $logged;

    const JWT_SECRET = '4ufghy934nfua43hgfp9238yhfw379yr';
    const JWT_ISSUER = 'https://davinci.edu.ar';

    /**
     * @param string $email
     * @param string $password
     * 
     * Recibe email y password para autenticar el usuario
     * 
     * @return bool
     */
    public function login($email, $password)
    {
        if($this->estaAutenticado()) {

            echo json_encode([
                'success' => false,
                'errores' => 'Ya estas logeado.'
            ]);

            die();

        }

        $user = (new User)->getByEmail($email);

        if($user !== null) {

            if(password_verify($password, $user->getPassword())) {

                $token = $this->generateJWT($user->getId());

                setcookie('token', (string) $token->toString(), [
                    'httponly' => true,
                    'samesite' => 'Lax',
                    'expires' => time() + 60*60*24
                ]);

                $this->id = $user->getId();
                $this->logged = true;

                return true;
            }
        }

        return false;
    }

    /**
     * @param int $id
     * 
     *  Genera un token de autenticación, que contenga el id provisto.
     * 
     * @return \Lcobucci\JWT\Token
     */
    public function generateJWT($id): \Lcobucci\JWT\Token
    {

        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded(self::JWT_SECRET)
        );

        $builder = $config->builder();

        $token = $builder
            ->issuedBy(self::JWT_ISSUER)
            ->issuedAt(new DateTimeImmutable())
            ->withClaim('id', $id)
            ->getToken($config->signer(), $config->signingKey());
        
        return $token;
    }

    /**
     * Cierra la sesión del usuario.
     * 
     * @return bool
     */
    public function logout()
    {
        setcookie('token', null, [
            'expires' => time() - 60*60*24,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $this->logged = false;
    }

    /**
     * Retorna si el usuario está autenticado o no.
     *
     * @return bool
     */
    public function estaAutenticado()
    {

        if($this->logged) {
            return true;
        }
        $token = $_COOKIE['token'] ?? null;
        return is_string($token) && $this->validateJWT($token);
    }


    /**
     * @param string $token
     * 
     * Verifica si el token es válido, en cuyo caso retorna un array con el id del usuario del token.
     * 
     * @return bool|array
     */
    public function validateJWT($RequestToken)
    {

        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded(self::JWT_SECRET)
        );

        $token = $config->parser()->parse($RequestToken);

        try {
            $constraints = [
                new SignedWith($config->signer(), $config->signingKey()),
                new IssuedBy(self::JWT_ISSUER)
            ];

            $config->validator()->assert($token, ...$constraints);

            $this->id = $token->claims()->get('id');
            return [
                'id' => $this->id
            ];
        } catch(\Exception $e) {
            return false;
        }

    }

    /**
     * Retorna el usuario autenticado.
     * Si no está autenticado, retorna null.
     *
     * @return null|User
     */
    public function getUsuario()
    {

        if(!$this->estaAutenticado()) {

            return null;
        }

        return (new User)->getByPk($this->id);
    }
}
