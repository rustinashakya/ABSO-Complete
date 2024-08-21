<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Fun;
use App\Models\Gallery;
use App\Models\Investment;
use App\Models\News;
use App\Models\Page;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\SlideImage;
use App\Models\Team;
use App\Models\Vacancy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::first();
        $services = Page::where('type', 'service')->get();
        $static_page = Page::where('type', 'static_page')->where('slug', 'who-we-are')->first();
        $work = Page::where('slug', 'our-work')->first();
        $client = Page::where('slug', 'our-clients')->first();
        $team= Page::where('slug', 'our-team')->first();
        $sectors = Page::where('type', 'sector')->get();
        $clients = Client::get();
        $teams = Team::with('designation')->orderBy('order_by', 'asc')->get();
        $fun_facts = Fun::get();
        $slider = SlideImage::first();
        return view('frontend.layouts.master', compact('siteSetting', 'services', 'static_page', 'sectors', 'clients', 'teams', 'fun_facts', 'slider', 'work', 'client', 'team'));
    }

    public function career()
    {
        $careers = Vacancy::with('level')->where('status', 'active')->where('deadline', '>=', date('Y-m-d H:i:s'))->orderBy('id', 'desc')->get();
        $positions = Vacancy::with('level')->where('status', 'inactive')->orWhere('deadline', '<', date('Y-m-d H:i:s'))->orderBy('id', 'desc')->get();
        return view('frontend.career', compact('careers', 'positions'));
    }

    public function career_apply($slug)
    {
        $applicant_id = Session::get('applicant_id') ?? null;
        $applicant = Applicant::where('id', $applicant_id)->first();
        $type = $slug == 'future' ? 'future' : 'job-details';
        $level = Vacancy::with('level')->where('slug', $slug)->first();
        $positions = $type == 'future' ? Vacancy::with('level')->where('type', 'future')->orderBy('id', 'desc')->get() : Vacancy::with('level')->where('type', 'job-details')->orderBy('id', 'desc')->get();
        return view('frontend.career_apply', compact('applicant', 'positions', 'level', 'type'));
    }

    public function career_preview($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $applicant = Applicant::where('id', $id)->first();
        return view('frontend.career_preview', compact('applicant', 'encrypted_id'));
    }

    public function career_edit($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $applicant = Applicant::where('id', $id)->first();
        $positions = $applicant->type == 'future' ? Vacancy::with('level')->where('type', 'future')->orderBy('id', 'desc')->get() : Vacancy::with('level')->where('type', 'job-details')->where('deadline', '>=', date('Y-m-d H:i:s'))->orderBy('id', 'desc')->get();
        return view('frontend.career_edit', compact('applicant', 'encrypted_id', 'positions'));
    }

    public function career_confirm($encrypted_id)
    {
        $id = decrypt($encrypted_id);

        try {
            $applicant = Applicant::where('id', $id)->update([
                'stage' => 1
            ]);

            $applicant_details = Applicant::where('id', $id)->first();
            // Get vacancy title and company name
            $vacancy_title = $applicant_details->vacancy->title ?? '' . ' ' . $applicant_details->vacancy->level->name ?? '';
            $company_name = env('APP_NAME');

            // Prepare email subject
            $subject = '[QYEC] Application for Vacancy #' . $applicant_details->vacancy_id . ' received';

            // Prepare mail data
            $maildata = [
                'name' => $applicant_details->name,
                'subject' => $subject,
                'to' => $applicant_details->email,
                'vacancy_id' => $applicant_details->vacancy_id,
                'vacancy_title' => $vacancy_title,
                'company_name' => $company_name
            ];
            $mail_send = Mail::send('email.applicant_success-mail', $maildata, function ($message) use ($maildata) {
                $mail_sender = config('app.mail_username') ?? env('MAIL_FROM_ADDRESS');
                $message->from($mail_sender, 'QYEC');
                $message->to($maildata['to']);
                $message->bcc('sagundhk@gmail.com');
                $message->subject($maildata['subject']);
            });
            if (!$mail_send) {
                throw new Exception('Failed to send email');
            }
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }

        if (Session::has('applicant_id')) {
            Session::forget('applicant_id');
        }

        return view('frontend.career_confirm', compact('applicant_details'));
    }

    public function career_details($slug)
    {
        $career = Vacancy::with('level')->where('slug', $slug)->first();
        return view('frontend.career_details', compact('career'));
    }

    public function static_page($slug)
    {
        $static_page = Page::where('type', 'static_page')->where('slug', $slug)->first();
        $headnav = 'about';
        return view('frontend.static_page', compact('static_page', 'headnav'));
    }

    public function sector($slug)
    {
        $sector = Page::where('type', 'sector')->where('slug', $slug)->first();
        $projects = Project::with('images', 'projectKpis', 'service')->where('page_id', $sector->id)->where('show', 1)->orderBy('id', 'desc')->get();

        $headnav = 'sectors';
        return view('frontend.sector', compact('sector', 'projects', 'headnav'));
    }

    public function service($slug)
    {
        $service = Page::with('serviceAccordions')->where('type', 'service')->where('slug', $slug)->first();
        $headnav = 'services';
        return view('frontend.service', compact('service', 'headnav'));
    }

    public function project()
    {
        $sectors = Page::where('type', 'sector')->get();
        $projects = Project::with('images', 'projectKpis', 'service')->where('show', 1)->orderBy('title', 'asc')->get();
        $headnav = 'projects';
        return view('frontend.project', compact('projects', 'sectors', 'headnav'));
    }

    public function project_details($slug)
    {
        $project = Project::with('images', 'page', 'projectKpis', 'service')->where('slug', $slug)->first();
        $headnav = 'projects';
        return view('frontend.project_details', compact('project', 'headnav'));
    }

    public function contact()
    {
        $headnav = 'contact';
        return view('frontend.contact_us', compact('headnav'));
    }

    public function contact_confirm()
    {
        $headnav = 'contact';
        return view('frontend.contact_confirm', compact('headnav'));
    }

    public function news()
    {
        $news = News::orderBy('published_date', 'desc')->paginate(6);

        return view('frontend.news', compact('news'));
    }

    public function news_details($slug)
    {
        $news = News::where('slug', $slug)->first();
        $newslist = News::orderBy('published_date', 'desc')->get();
        return view('frontend.news_details', compact('news', 'newslist'));
    }

    public function teams()
    {
        $teams = Team::where('type', 'expert')->orderBy('order_by', 'asc')->get();
        return view('frontend.teams', compact('teams'));
    }

    public function clientele()
    {
        $clients = Client::orderBy('created_at', 'asc')->get();
        return view('frontend.clientele', compact('clients'));
    }

    public function team_details($slug)
    {
        $team = Team::where('slug', $slug)->first();
        $teams = Team::where('type', 'expert')->orderBy('order_by', 'asc')->take(3)->get();
        return view('frontend.team_details', compact('team', 'teams'));
    }

    public function gallery()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('frontend.gallery', compact('galleries'));
    }

    public function history()
    {
        return view('frontend.history');
    }

    public function investment()
    {
        $investments = Investment::with('page')->latest()->get();
        $headnav = 'investments';
        return view('frontend.investment', compact('investments', 'headnav'));
    }

    public function investment_details($slug)
    {
        $investment = Investment::where('slug', $slug)->first();
        return view('frontend.investment_details', compact('investment'));
    }

    public function error()
    {
        return view('frontend.404');
    }
}
