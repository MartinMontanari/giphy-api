<?php
//declare(strict_types=1);
//
//namespace App\domain\services;
//
//use App\application\commands\Auth\LoginUserCommand;
//use App\application\commands\Auth\RegisterUserCommand;
//use App\domain\Models\User;
//use App\infrastructure\Exceptions\RepositoryException;
//use App\infrastructure\repositories\UserRepository;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Log;
//
//readonly class UserService
//{
//
//    public function __construct(
//        private UserRepository $userRepository,
//    )
//    {
//    }
//
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
//
//    public function logInUser(LoginUserCommand $loginUserCommand): string
//    {
//
//    }
//
//
//    private function getUserByEmail(string $email): User|null
//    {
//        $user = $this->userRepository->findOneByEmail($email);
//        if(!$user) {
//            throw new NotFoundException("User not found or does not exist");
//        }
//    }
//}
