<?php
declare(strict_types=1);

namespace App\infrastructure\services;

use App\domain\Models\User;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\Exceptions\UnauthorizedException;
use App\infrastructure\repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class UserService
{

    public function __construct(
        private UserRepository $userRepository,
    )
    {
    }

    /**
     * @param array $userData
     * @param string $hashedPassword
     * @return int
     */
    public function saveUser(array $userData, string $hashedPassword): int
    {
        Log::info("Mapping the user data to save...", ["UserService", $userData]);

        $user = new User();
        $user->user_name = $userData['userName'];
        $user->first_name = $userData['firstName'];
        $user->last_name = $userData['lastName'];
        $user->email = $userData['email'];
        $user->password = $hashedPassword;

        $this->userRepository->save($user);
        $userId = $user->id;
        Log::info("User saved... user_id -> {$userId}", ["UserService", "saveUser()", "- END -"]);

        return $userId;
    }


    /**
     * @param string $email
     * @return User
     * @throws NotFoundException
     */
    public function getUserByEmail(string $email): User
    {
        try {
            Log::info("Find a user in the database starting... email -> $email", ["UserService", "getUserByEmail($email)", "- START -"]);
            $user = $this->userRepository->findOneByEmail($email);

            Log::info("user found... user -> $user->first_name $user->last_name | $user->email", ["UserService", "getUserByEmail($email)", "- END -"]);
            return $user;
        } catch (ModelNotFoundException $exception) {
            Log::error("User not found on database, email -> $email", ["UserRepository", "getUserByEmail($email)", "Error" => $exception->getMessage()]);
            throw new NotFoundException([$exception->getMessage()]);
        }

    }

    /**
     * @param int $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIfUserExists(int $id): void
    {
        $this->findOneUserByIdOrFail($id);
    }

    /**
     * @param string $email
     * @param string $plainUserPassword
     * @return User
     * @throws UnauthorizedException
     */
    public function loginAttempt(string $email,string $plainUserPassword): User
    {
        Log::info('Checking user credentials...', ["UserService"]);
        $attempt = Auth::attempt(["email" => $email, "password" => $plainUserPassword]);
        if (!$attempt) {
            throw new UnauthorizedException(['Invalid email or password']);
        }
        Log::info('Credentials ok.', ["UserService"]);
        $user = Auth::user();

        Log::info('User authenticated.', ["UserService", "- END -"]);
        return $user;
    }

    /**
     * @param int $id
     * @return void
     * @throws NotFoundException
     */
    private function findOneUserByIdOrFail(int $id): void
    {
        try {
            Log::info("Find a user in the database starting... id -> $id", ["UserService", "- START -"]);
            $user = $this->userRepository->findOneById($id);
            Log::info("user found... user -> $user->first_name $user->last_name | $user->email", ["UserService", "- END -"]);
        } catch (ModelNotFoundException $exception) {
            Log::error("User not found on database, id -> $id", ["UserRepository", "Error" => $exception->getMessage()]);
            throw new NotFoundException([$exception->getMessage()]);
        }
    }
}
