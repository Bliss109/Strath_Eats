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
        echo json_encode($profile);
        break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            if(isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                http_response_code(400);
                echo json_encode(['message' => 'Invalid email format']);
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
            if (isset($_FILES['profile_picture'])){
                $uploadDir = '../uploads/profile_pictures/';

                if(!file_exists($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if(!in_array($_FILES['profile_picture']['type'], $allowedTypes)){
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid file type']);
                    exit;
                }

                $fileName = time() . '_' . basename($_FILES['profile_picture']['name']);
                $uploadFilePath = $uploadDir . $fileName;

                if(move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFilePath)){
                    if($user->updateProfilePicture($userId, $fileName)){
                        echo json_encode(['message' => 'Profile picture updated successfully', 
                        'file_path' => 'uploads/profile_pictures/' . $fileName
                    ]);
                }else{
                    unlink($uploadFilePath);
                    http_response_code(400);
                    echo json_encode(['message' => 'Failed to upload profile picture']);
                }
            }else{
                http_response_code(400);
                echo json_encode(['message' => 'No profile picture uploaded']);
            }
            break;
        }
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method not allowed']);
                break;
}

?>