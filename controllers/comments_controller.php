<?php
class comments_controller extends main_controller
{
    protected comment_model $comment;
    public function __construct()
    {
        $this->comment = comment_model::getInstance();
        parent::__construct();
    }
    public function add($params)
    {
        if (isset($_POST['comment_content'])) {
			$id = $_SESSION['auth']['id'];
            $commentData = [
                'user_id' => $id,
                'blog_id' => $params['id'],
                'comment_content' => $_POST['comment_content'],
            ];
            $path = '';
            $commentData['path'] = $path;
			if (!empty($commentData['comment_content'])) {
				$obj_data = $this->comment->addRecord($commentData);
                if ($obj_data) {
                    $data = [
                        'status' => true,
                        'result' => $obj_data
                    ];
                    exit(json_encode($data));
                }
			}
		}
    }

    public function reply() {
        if (isset($_POST['reply_content'])) {
            $id = $_SESSION['auth']['id'];
            $commentData = [
                'user_id' => $id,
                'blog_id' => $_POST['blog_id'],
                'comment_content' => $_POST['reply_content'],
            ];
            $path =  '';
            $commentData['path'] =  $path;
            $obj_data = $this->comment->addReplyRecord($_POST['parentId'], $commentData);
            if ($obj_data) {
                $data =  [
                    'status' => true,
                    'result'=> $obj_data
                ];
                exit(json_encode($data));
            }
        }
    }

    public function edit() {
        $oldCmt = $this->comment->getRecord($_POST['id']);
        $newCmt = $oldCmt;
        if ($_POST['edit_content'] != $oldCmt['comment_content']) {
            // $historyCmt = [
            //     'comment_id' => $oldCmt['id'],
            //     'comment_content' => $oldCmt['comment_content'],
            // ];
            //$this->comment->addHistoryComment($historyCmt);
            $newCmt['comment_content'] = $_POST['edit_content'];
            $this->comment->editRecord($_POST['id'], $newCmt);
            $obj_data = $this->comment->getRecord($_POST['id']);
            if ($obj_data) {
                $data = [
                    'status' => true,
                    'result' => $obj_data,
                ];
                exit(json_encode($data));
            }
        }
    }

    public function delete($params) {
        $likeModel = like_model::getInstance();
        $get_all_comment_blog = $this->comment->getAllRecords("*", "blog_id =" .$_POST['blog_id']);
        $detail_comment = $this->comment->getRecord($params['id']);
        $this->comment->delRecord($detail_comment['id']);
        foreach ($get_all_comment_blog as $cmt) {
			if (str_contains($cmt['path'], $detail_comment['path'])) {
				$this->comment->delRecord($cmt['id']);
                $likeModel->delLikeRecord($_SESSION['auth']['id'], $cmt['id']);
			}
		}
        $data = [
            'status' => true
        ];
        exit(json_encode($data));
    }
}
