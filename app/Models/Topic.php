<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    //number of topic
    public function numberTickets($id)
    {
        return $this::find($id)->tickets()->get();
    }

    public function allNumberTickets()
    {
        $topicList = [];
        $countTicket = 0;
        foreach ($this->all() as $topic){
            $topicList[$topic['id']] = $topic->numberTickets($topic['id'])->count();
        }
        return $topicList;
    }

    public function topicWithChildren($id)
    {
        return $this->where('topic_parent_id',$id)->orWhere('id',$id)->pluck('id')->toArray();
    }

    public function allNumberTicketAndChildren()
    {
        $topicList = [];
        $topicAndTicketList = [];

        foreach($this->all() as $topic){
            $topicList[$topic['id']] = $topic->tickets()->get()->count();
        }

        foreach($this->all() as $topic){
            $countTicket = 0;
            foreach($this->topicWithChildren($topic['id']) as $child){
                $countTicket += $topicList[$child];
            }

            $topicAndTicketList[$topic['id']] = $countTicket;
        }

        return $topicAndTicketList;
    }

    public function topics()
    {

    }
}
