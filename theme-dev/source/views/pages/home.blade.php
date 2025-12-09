<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    Tailwind Starter Template - Landing Page Template: Tailwind Toolbox
  </title>
  <meta name="description" content="Simple landind page">
  <meta name="keywords" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
  <!--Replace with your tailwind.css once created-->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
  <!-- Define your gradient here - use online tools to find a gradient matching your branding-->
  <style>
    .gradient {
      background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
    }
  </style>
</head>

<body class="leading-normal tracking-normal text-white gradient">
  <section>
      <?= blade('sections.home.hero', [ 'title' => 'Titulo'])?>
  </section>
</body>

</html>