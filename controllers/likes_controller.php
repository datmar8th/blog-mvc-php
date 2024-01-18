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
        $like_data = [
            'user_id' => $id,
            'type_id' => $params['id'],
            'type' => 'comment',
        ];
        $comment_data = $this->comment->getRecord($params['id']);
        $get_all_likes = $this->like->getAllRecords();
        foreach ($get_all_likes as $data) {
            if ($data['user_id'] == $like_data['user_id'] &&
                $data['type_id'] == $like_data['type_id'] &&
                $data['type'] == $like_data['type']) {
                $comment_data['like_count'] -= 1;
                $this->comment->editRecord($comment_data['id'], $comment_data);
                $this->like->delRecord($data['id']);
                exit(json_encode($comment_data['like_count']));
            }
        }
        $comment_data['like_count'] += 1;
        $this->comment->editRecord($comment_data['id'], $comment_data);
        $this->like->addRecord($like_data);
        exit(json_encode($comment_data['like_count']));
    }
}
