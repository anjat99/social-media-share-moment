<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\user\InsertCommentRequest;
use App\Models\Comment;
use App\Models\Review;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends FrontendController
{

    public function index(Request $request)
    {
        $this->data["comments"] = Comment::with('user', 'story')->get();
        return view('frontend.pages.comments.index', $this->data);
    }

    public function create()
    {
        return view('frontend.pages.stories.create-comment-form', $this->data);
    }

    public function store(InsertCommentRequest $request)
    {

        try {
            $comment = new Comment();
            $comment->comment_text = $request->input('message');
            $comment->user_id = session('user')->id;
            $comment->post_id = $request->post_id;
            $comment->is_reported = 0;
            $comment->reported_at = null;
            $saved = $comment->save();
            $result = $saved;

            $user = User::find($comment->user_id);
            session()->put('user',$user);
            $allComments = Comment::with('user','story')->whereHas('story',function($query) use ($request){
                return $query->where('post_id','=',$request->post_id);
            })->get();

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "create comment";
                $userActivity->save();
            }

            if($result)
                return response(['message' => 'Success','comments'=>$allComments], Response::HTTP_CREATED);
            else
                return response(['message'=> 'Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch(\Exception $ex) {
            \Log::error($ex->getMessage());
            return response(['message'=> $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function reportComment($id){
        try {
            $comment = Comment::find($id);
            $userOfComment = User::find($comment->user_id);
            $userOfComment->is_reported = 1;
            $userOfComment->reported_at = date("Y-m-d H:i:s");
            $userOfComment->save();

            $comment->is_reported = 1;
            $comment->reported_at = date("Y-m-d H:i:s");
            $comment->save();

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "report comment with id: $id";

                $userActivity->save();
            }

            $user = User::find(session("user")->id);
            session()->put('user',$user);

            return redirect()->back()->with('successReportComment', 'Comment successfully reported!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorReportComment', $ex->getMessage());
        }
    }

    public function cancelReportComment($id){
        try {
            $comment = Comment::find($id);
            $userOfComment = User::find($comment->user_id);
            $userOfComment->is_reported = 0;
            $userOfComment->reported_at = null;
            $userOfComment->save();

            $comment->is_reported = 0;
            $comment->reported_at = null;
            $comment->save();



            $user = User::find(session("user")->id);
            session()->put('user',$user);

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "cancel report for comment with id: $id";

                $userActivity->save();
            }

            return redirect()->back()->with('successCancelReportComment', 'Successfully canceled report!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorCancelReportComment', $ex->getMessage());
        }
    }
}
