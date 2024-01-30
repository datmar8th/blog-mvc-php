<?php
class likes_controller extends main_controller
{

    public function add($params)
    {
        $likeModel = like_model::getInstance();
        $commentModel = comment_model::getInstance();
        $id = $_SESSION['auth']['id'];
        $like_data = [
            'user_id' => $id,
            'type_id' => $params['id'],
            'type' => 'comment',
        ];
        $comment_data = $commentModel->getRecord($params['id']);
        $get_all_likes = $likeModel->getAllRecords();
        foreach ($get_all_likes as $data) {
            if ($data['user_id'] == $like_data['user_id'] &&
                $data['type_id'] == $like_data['type_id'] &&
                $data['type'] == $like_data['type']) {
                $comment_data['like_count'] -= 1;
                $commentModel->editRecord($comment_data['id'], $comment_data);
                $likeModel->delRecord($data['id']);
                exit(json_encode($comment_data['like_count']));
            }
        }
        $comment_data['like_count'] += 1;
        $commentModel->editRecord($comment_data['id'], $comment_data);
        $likeModel->addRecord($like_data);
        exit(json_encode($comment_data['like_count']));
    }
}
