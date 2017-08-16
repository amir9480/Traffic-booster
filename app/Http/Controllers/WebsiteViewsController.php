<?php

namespace Test\Http\Controllers;

use Illuminate\Http\Request;

use Test\WebsiteViews;
use Test\Websites;
use Test\UserManagment;
use Test\Likes;
use Test\Comments;

use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;


require_once(app_path().DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'recaptcha'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php');

use ReCaptcha\ReCaptcha;

// آیکون ها و اسم های آن ها
const icon_images=
[
    ['name' => 'ببر'       ,      'file' => 'images/1498764215_Tiger.png'],
    ['name' => 'گوریل'     ,      'file' => 'images/1498764228_Gorilla.png'],
    ['name' => 'کرگدن'     ,      'file' => 'images/1498764229_Rhino.png'],
    ['name' => 'پلنگ'      ,      'file' => 'images/1498764236_Panther_Leopard.png'],
    ['name' => 'کوسه'      ,      'file' => 'images/1498764239_Tuna.png'],
    ['name' => 'خرس'       ,      'file' => 'images/1498764242_Polar_Bear.png'],
    ['name' => 'فیل'       ,      'file' => 'images/1498764244_Elephant.png'],
];


class WebsiteViewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('usersonly');
    }
    
    // درخواست مشاهده ی سایت به صورت ایجکس
    public function requestVisit(Request $r)
    {
        $able=true;
        $now=Carbon::now();
        $u = UserManagment::getCurrentUser($r);
        
        
        
        $w=WebsiteViews::whereRaw('website_id = '.$r->input('website_id').' AND user_id = '.$u->id )->first();
        // اگه تاحالا مشاهده ای با این مشخصات وجود نداشت یکی میسازیم
        if($w===null)
        {
            WebsiteViews::create([
                'user_id'=>$u->id,
                'website_id'=>$r->input('website_id'),
                'view_token'=>str_random(16),
                'last_view'=> (Carbon::now()->subDay()) // یه روز ازش کم میکنیم تا ارور نده موقع مشاهده . حداقل یک ساعت فاصله لازمه
            ]);
            $w=WebsiteViews::whereRaw('website_id = '.$r->input('website_id').' AND user_id = '.$u->id )->first();
        }
        $wd = Websites::where('id',$w->website_id)->first();
        
        $webowner = $wd->user;
        
        // اگه وبسایت مورد نظر یا کاربر مورد نظر وجود نداشته حتما یه خراب کاری وجود داره
        if($wd===null or $u === null)
        {
            return response()->json([
                'able'=>false,
            ]);
        }
        
        
        // اگه در مدت یک ساعت قبل آخرین بار بازدید شده کاربر نمیتونه امتیاز بگیره
        if($now->diffInHours(Carbon::parse($w->last_view))<1)
        {
            $able=false;
        }
        
        if($able==true)
        {
            $w->last_view = Carbon::now();
            // یه مقدار اعتبار سنجی جدید حاضر میکنیم
            $w->view_token=str_random(16);
            $w->save();
        }
        
        $wu = UserManagment::select(['name','username'])->where('id',$wd->user_id)->first();
        
        $sw = ($u->id==$wd->user_id);
        
        $liked =!(Likes::where('user_id',$u->id)->where('website_id',$wd->id)->first()===null);
        
        $nopoint = (bool)($webowner->point < $wd->pointpervisit);
        
        return response()->json([
                'able'=>$able,
                'selfwebsite'=>$sw,
                'weburl'=>$wd->url,
                'title'=>$wd->title,
                'user_name'=>$wu->name,
                'the_user_name'=>$wu->username,
                'timer'=>(($wd->pointpervisit)/5),
                'thepoint'=>$wd->pointpervisit,
                'liked'=>$liked,
                'nopoint'=>$nopoint
            ]);
    }
    
    
    // درخواست فرم اعتبار سنجی
   public function requestPoint(Request $r)
    {
        $able=true;
        $now=Carbon::now();
        $u = UserManagment::getCurrentUser($r);
        $w=WebsiteViews::whereRaw('website_id = '.$r->input('website_id').' AND user_id = '.$u->id )->first();
        $wd = Websites::where('id',$w->website_id)->first();
        
        // اگه فاصله زمانی بین انتخاب گزینه و لحظه شروع مشاهده کمتر از این مقدار بوده یعنی کاربر سعی کرده دستی مقدار بده و کد جاوا اسکریپت رو دور بزنه
        if($now->diffInSeconds(Carbon::parse($w->last_view))<$wd->pointpervisit/5
                ||$w->view_token=='0') // اگه این صفر بود یعنی این مشاهده امتیازش قبلا دریافت شده
        {
            $w->view_token='0'; //صفر به این معنیه که کاربر امتیازش رو گرفته
            $w->save();
            return response()->json([
                'able'=>false,
            ]);
        }
        
        //$r->session()->put('view_token',$w->view_token);
        $randstr=array();
        $selection=array();
        do{
         $randstr[0]= str_random(16);
         $randstr[1]= str_random(16);
         $randstr[2]= str_random(16);
        }while($randstr[0]==$w->view_token || $randstr[1]==$w->view_token || $randstr[2]==$w->view_token ||
                $randstr[0]==$randstr[1] || $randstr[0]==$randstr[2] || $randstr[1]==$randstr[2] );
        do{
            $selection[0] = rand()%count(icon_images);
            $selection[1] = rand()%count(icon_images);
            $selection[2] = rand()%count(icon_images);
        }while($selection[0] ==$selection[1]||$selection[1]==$selection[2]||$selection[2]==$selection[0]);
        
        $randnum = rand()%3;
        
        $output=array();
        
        $randstr[3]= Carbon::now()->format('Y_U');
        
         
        for($i=0;$i<3;$i++)
        {
            $output['v'.$i]['value']=$randstr[$i];
            if($randnum==$i)
            {
                $output['v'.$i]['name']=$selection[$i];
            }
            else
            {
                $output['v'.$i]['name']=icon_images[$selection[$i]]['name'];
            }
        }
        $s = $output['v'.$randnum]['name'];
        $output['v'.$randnum]['name']=icon_images[$selection[$randnum]]['name'];
        $output['v'.$randnum]['value']=$w->view_token;
        $output['able']=$able;
        $output['rand_session']=$randstr[3];
        
        $r->session()->put('current_selection',$selection[$randnum]);
        
        
        return response()->json($output);
    }
    
    
    public function getCurrectImage(Request $r)
    {
        if($r->session()->exists('current_selection')==false)
        {
            return response()->file(icon_images[0]['file']);
        }
        $s = $r->session()->get('current_selection');
        // Just for Testing
        $r->session()->forget('current_selection');
        
        $r->header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $r->header("Cache-Control: post-check=0, pre-check=0", false);
        $r->header("Pragma: no-cache");
        
        return response()->file(icon_images[$s]['file']);
    }
    
    
    public function submitPoint(Request $r)
    {
        $now=Carbon::now();
        $uc = UserManagment::getCurrentUser($r);
        $wv=WebsiteViews::whereRaw('website_id = '.$r->input('website_id').' AND user_id = '.$uc->id )->first();
        $website = Websites::where('id',$wv->website_id)->first();
        $uw = $website->user;
        
        if($now->diffInSeconds(Carbon::parse($wv->last_view))< $website->pointpervisit/5 ||
                $r->input('view_token')!=$wv->view_token)
        {
                    
            $wv->view_token=0;
            $wv->save();
            return response()->json([
                'ok'=>false,
                'text'=>'متاسفانه امتیازی برای شما ثبت نشد',
                'point'=>$uc->point
                ]);
        }
        $wv->view_token=0;
        $uc->point+=$website->pointpervisit;
        $uw->point-=$website->pointpervisit;
        $website->views+=1;
        
        $wv->save();
        $uc->save();
        $uw->save();
        $website->save();
        
        return response()->json([
                'ok'=>true,
                'text'=>'تبریک . شما '.$website->pointpervisit.' امتیاز کسب کردید',
                'point'=>$uc->point
                ]);
    }
    
    
    public function getComments(Request $r,$website_id)
    {
        $cuser = UserManagment::getCurrentUser($r);
        $comments = Comments::select(['id','user_id','content'])->where('website_id',$website_id)->orderBy('created_at','desc')->get();
        $users = array();
        foreach ($comments as $c)
        {
            $users[]=UserManagment::select(['name'])->where('id',$c->user_id)->first();
        }
        $cweb = Websites::where('id',$website_id)->first();
        
        return response()->json([
                    'comments'=>$comments,
                    'users'=>$users,
                    'current_user_id'=>$cuser->id,
                    'ownwebsite'=> ((bool)($cweb->user_id == $cuser->id))
                ]);
    }
    
    public function addComment(Request $r)
    {
        $recaptcha_r=new ReCaptcha(Config::get('app.recaptcha_secret'));
        $recaptcha_response = $recaptcha_r->verify($r->input('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
        if($recaptcha_response->isSuccess()===false || empty($r->input('content','')))
        {
            return response()->json([
                   'done'=>false
                  ]);
        }
        $cuser = UserManagment::getCurrentUser($r);
        Comments::create(['website_id'=>$r->input('website_id'),'user_id'=>$cuser->id,'content'=>$r->input('content')]);
        
        return response()->json([
                  'done'=>true
                  ]);
    }
    
    public function deleteComment(Request $r)
    {
        $cuser = UserManagment::getCurrentUser($r);
        $com = Comments::where('id',$r->input('cid'))->first();
        $w = Websites::where('id',$com->website_id)->first();
        if($com->user_id != $cuser->id && $w->user_id != $cuser->id && $com->is_admin==false)
        {
            return response()->json([
                  'done'=>false
                  ]);
        }
        $com->delete();
        return response()->json([
                  'done'=>true
                  ]);
    }
    
    
}
