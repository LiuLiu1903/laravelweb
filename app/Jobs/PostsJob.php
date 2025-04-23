<?php
 
 namespace App\Jobs;
 
 use Illuminate\Contracts\Queue\ShouldQueue;
 use Illuminate\Foundation\Queue\Queueable;
 use Illuminate\Queue\InteractsWithQueue;
 use Illuminate\Queue\SerializesModels;
 use Illuminate\Foundation\Bus\Dispatchable;
 
 use App\Models\Post;
 use App\Models\User;
 use Illuminate\Support\Facades\Mail;
 use App\Mail\EmailPost;
 
 
 class PostsJob implements ShouldQueue
 {
     use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;
 
     /**
      * Create a new job instance.
      */
     protected $post;
     public function __construct($post)
     {
         //
         $this->post = $post;
     }
 
     /**
      * Execute the job.
      */
     public function handle(): void
     {
         //
         $post = $this->post;
         $user_Email = User::where('id',$post->user_id)->first()->email;
 
         Mail::to($user_Email)->send(new EmailPost($post->title,$post->slug));
 
     }
 }