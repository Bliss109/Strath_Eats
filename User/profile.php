<?php
session_start();
require_once '../User/user.php';

if(!isset($_SESSION['user_id'])){
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

$user = new User();
$userId = $_SESSION['user_id'];

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $profile = $user->getUserProfile($userId);
        if (!$profile) {
            http_response_code(404);
            echo json_encode(['message' => 'Profile not found']);
            exit;
        }
        echo json_encode($profile);
        break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            if(isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                http_response_code(400);
                echo json_encode(['message' => 'Invalid email format']);
                exit;
            }

            if (isset($data['phone_number']) && !preg_match('/^[0-9+\-\s()]{8,20}$/', $data['phone_number'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid phone number format']);
                exit;
            }

            if (isset($data['student_id']) && !preg_match('/^[A-Za-z0-9]{5,20}$/', $data['student_id'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid student ID format']);
                exit;
            }

            if($user->updateProfile($userId, $data)){
                echo json_encode(['message' => 'Profile updated successfully']);
            }else{
                http_response_code(400);
                echo json_encode(['error' => 'Failed to update profile']);
            }
            break;

        case 'PUT':
            if (isset($_FILES['profile_picture'])) {
                if ($_FILES['profile_picture']['size'] > 5000000) {
                    http_response_code(413);
                    echo json_encode(['message' => 'File too large']);
                    exit;
                }
                
                $uploadDir = '../uploads/profile_pictures/';

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['profile_picture']['type'], $allowedTypes)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid file type']);
                    exit;
                }

                $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
                $uploadFilePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFilePath)) {
                    if ($user->updateProfilePicture($userId, $fileName)) {
                        echo json_encode([
                            'message' => 'Profile picture updated successfully',
                            'file_path' => 'uploads/profile_pictures/' . $fileName
                        ]);
                    } else {
                        unlink($uploadFilePath);
                        http_response_code(400);
                        echo json_encode(['message' => 'Failed to upload profile picture']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Failed to move uploaded file']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'No profile picture uploaded']);
            }
            break;
        

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['remove_profile_picture'])) {
                
                $profile = $user->getUserProfile($userId);
                if ($profile && $profile['profile_picture']) {
                    $picturePath = '../uploads/profile_pictures/' . $profile['profile_picture'];
                    
                    
                    if (file_exists($picturePath) && unlink($picturePath)) {
                        if ($user->updateProfilePicture($userId, null)) {
                            echo json_encode(['message' => 'Profile picture removed successfully']);
                            exit;
                        }
                    }
                }
                http_response_code(400);
                echo json_encode(['message' => 'Failed to remove profile picture']);
                exit;
            }
            break;

        case 'PATCH':
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['current_password']) && isset($data['new_password'])) {
               
                if (strlen($data['new_password']) < 8) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Password must be at least 8 characters long']);
                    exit;
                }

                 
                if ($user->verifyPassword($userId, $data['current_password'])) {
                    if ($user->updatePassword($userId, $data['new_password'])) {
                        echo json_encode(['message' => 'Password updated successfully']);
                        exit;
                    }
                    http_response_code(400);
                    echo json_encode(['message' => 'Failed to update password']);
                    exit;
                }
                
                http_response_code(401);
                echo json_encode(['message' => 'Current password is incorrect']);
                exit;
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            break;
}

?>