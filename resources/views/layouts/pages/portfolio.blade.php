@extends('layouts.master_home')

@section('home_content')

      <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Portolio</h2>
          <ol>
            <li><a href="index.html">Home</a></li>
            <li>Portolio</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row" data-aos="fade-up">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up">

           @foreach ($portfolio_pics as $pic)
            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <img src="{{ asset( $pic->image ) }}" class="img-fluid" alt="">
                <div class="portfolio-info">
                    <h4>Portfolio</h4>
                    <p>Portfolio</p>
                    <a href="{{ asset($pic->image) }}" data-gall="portfolioGallery" class="venobox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
                    {{-- <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> --}}
                </div>
          </div>
         @endforeach


     
  

        



     

   
    

        </div>

      </div>
    </section><!-- End Portfolio Section -->

@endsection