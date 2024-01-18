<?php
class likes_controller extends main_controller
{
    protected like_model $like;
    protected comment_model $comment;
    public function __construct()
    {
        $this->like = like_model::getInstance();
        $this->comment = comment_model::getInstance();
        parent::__construct();
    }

    public function add($params)
    {
        $id = $_SESSION['auth']['id'];
        $likeData = [
            'user_id' => $id,
            'type_id' => $params['id'],
            'type' => 'comment',
        ];
        $commentData = $this->comment->getRecord($params['id']);
        $get_all_likes = $this->like->getAllRecords();
        foreach ($get_all_likes as $data) {
            if (
                $data['user_id'] == $likeData['user_id'] &&
                $data['type_id'] == $likeData['type_id'] &&
                $data['type'] == $likeData['type']
            ) {
                $commentData['like_count'] -= 1;
                $this->comment->editRecord($commentData['id'], $commentData);
                $this->like->delRecord($data['id']);
                exit(json_encode($commentData['like_count']));
            }
        }
        $commentData['like_count'] += 1;
        $this->comment->editRecord($commentData['id'], $commentData);
        $this->like->addRecord($likeData);
        exit(json_encode($commentData['like_count']));
    }
}
