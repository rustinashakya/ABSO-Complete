<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Gallery;
use App\Models\Investment;
use App\Models\News;
use App\Models\Page;
use App\Models\Project;
use App\Models\Team;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/about-qyec')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/organisational-chart')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/news')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/our-team')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/investments')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/legal-documents')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/our-clientele')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/contact-us')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/career')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()))
            ->add(Url::create('/projects')
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate(now()));

        // Fetch all services from the database
        $services = Page::where('type', 'service')->get();

        // Loop through each service and add it to the sitemap
        foreach ($services as $service) {
            $sitemap->add(Url::create("/services/{$service->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($service->updated_at));
        }
        // Fetch all sectors from the database
        $sectors = Page::where('type', 'sector')->get();

        // Loop through each sector and add it to the sitemap
        foreach ($sectors as $sector) {
            $sitemap->add(Url::create("/sectors/{$sector->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($sector->updated_at));
        }
        // Fetch all news from the database
        $news = News::get();

        // Loop through each news and add it to the sitemap
        foreach ($news as $new_s) {
            $sitemap->add(Url::create("/news/{$new_s->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($new_s->updated_at));
        }
        // Fetch all teams from the database
        $teams = Team::where('type', 'expert')->get();

        // Loop through each team and add it to the sitemap
        foreach ($teams as $team) {
            $sitemap->add(Url::create("/out-team/{$team->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($team->updated_at));
        }
        // Fetch all projects from the database
        $projects = Project::get();

        // Loop through each project and add it to the sitemap
        foreach ($projects as $project) {
            $sitemap->add(Url::create("/projects/{$project->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($project->updated_at));
        }
        // Fetch all investments from the database
        $investments = Investment::get();

        // Loop through each investment and add it to the sitemap
        foreach ($investments as $investment) {
            $sitemap->add(Url::create("/investments/{$investment->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($investment->updated_at));
        }
        // Fetch all legal documents from the database
        $legal_documents = Gallery::get();

        // Loop through each legal document and add it to the sitemap
        foreach ($legal_documents as $legal_document) {
            $sitemap->add(Url::create("/legal-documents/{$legal_document->id}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($legal_document->updated_at));
        }

        // Fetch all our clientele from the database
        $clienteles = Client::get();

        // Loop through each client and add it to the sitemap
        foreach ($clienteles as $clientele) {
            $sitemap->add(Url::create("/legal-documents/{$clientele->id}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($clientele->updated_at));
        }

        // Fetch all our careers from the database
        $careers = Vacancy::where('type', 'job-details')->get();

        // Loop through each career and add it to the sitemap
        foreach ($careers as $career) {
            $sitemap->add(Url::create("/legal-documents/{$career->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setLastModificationDate($career->updated_at));
        }

        return $sitemap->toResponse(request());
    }
}
