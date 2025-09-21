<section class="py-5 py-lg-6" id="portfolio">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Selected Work</h2>
            <p class="text-secondary">A few recent builds and collaborations.</p>
        </div>
        <div class="row g-4">
            @foreach(config('solutions.projects') as $project)
                <x-portfolio-card :title="$project['title']" :tag="$project['tag']" :img="$project['img']" :link="$project['link']"/>
            @endforeach
        </div>
    </div>
</section>
