<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/assets/css/styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <!--Page Header-->
    <header class="page-header py-3">
      <div class="container">
        <span class="logo h4">
          <a class="text-decoration-none" href="/" style="color: inherit">{{ $config['website'] }}</a>
        </span>
      </div>
    </header>
    <!-- / Page Header-->

    <!--Page Content-->
    <section class="page-body">
      <div class="container">{!! $content !!}</div>
    </section>
    <!-- / Page Content-->

    <!--Page Footer-->
    <footer class="page-footer">
      <div class="container text-center py-3">
        {{ $config['website'] }}&copy;{{ date('Y') }}
      </div>
    </footer>
    <!-- / Page Footer-->
  </body>
</html>
