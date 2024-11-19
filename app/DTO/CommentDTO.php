<?php

namespace App\DTO;

class CommentDTO
{
    public readonly int $postId;
    public readonly string $comment;

    /**
     * @param int $authorId
     * @param string $comment
     */
    public function __construct(int $postId, string $comment)
    {
        $this->postId = $postId;
        $this->comment = $comment;
    }


}
