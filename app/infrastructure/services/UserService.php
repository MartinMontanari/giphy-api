<?php
declare(strict_types=1);

namespace App\infrastructure\services;

use App\domain\Models\User;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

readonly class UserService
{

    public function __construct(
        private UserRepository $userRepository,
    )
    {
    }

//    /**
//     * @param RegisterUserCommand $registerUserCommand
//     * @throws RepositoryException
//     */
//    public function saveUser(RegisterUserCommand $registerUserCommand)
//    {
//        try {
//            $userData = $registerUserCommand->getData();
//            $hashedPassword = Hash::make($userData['password']);
//
//            $filteredUserData = array_filter($userData, function($value, $key) {
//                return $key !== 'password';
//            }, ARRAY_FILTER_USE_BOTH);
//
//            Log::info("Mapping the user data to save...", ["UserService", $filteredUserData]);
//            $user = new User();
//            $user->user_name = $userData['userName'];
//            $user->first_name = $userData['firstName'];
//            $user->last_name = $userData['lastName'];
//            $user->email = $userData['email'];
//            $user->password = $hashedPassword;
//
//            $this->userRepository->save($user);
//        }
//        catch (\Exception $exception) {
//            Log::error("User save process has failed... Error message ->{$exception->getMessage()}" , ["UserService", $exception]);
//            throw new RepositoryException([$exception]);
//        }
//    }

//    public function logInUser(LoginUserCommand $loginUserCommand): string
//    {
//
//    }

    /**
     * @param int $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIfUserExists(int $id): void
    {
        $this->findOneById($id);
    }

    /**
     * @param int $id
     * @return void
     * @throws NotFoundException
     */
    private function findOneById(int $id): void
    {
        try {
            Log::info("Find a user in the database starting... id -> $id", ["UserService", "findOneById($id)", "- START -",]);
            $user = $this->userRepository->findOneById($id);

            Log::info("user found... user -> $user->first_name $user->last_name | $user->email", ["UserService", "findOneById($id)", "- END -",]);
            return;
        } catch (ModelNotFoundException $exception) {
            Log::error("User not found on database, id -> $id", ["UserRepository", "findOneById($id)", "Error" => $exception->getMessage()]);
            throw new NotFoundException([$exception->getMessage()]);
        }
    }
}
