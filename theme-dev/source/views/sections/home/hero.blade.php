<div class="pt-24">
  <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">

    <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
      
      <p class="uppercase tracking-loose w-full text-md"> 
        {{ carbon_get_the_post_meta('home_headline') }}
      </p>

      <h1 class="my-4 text-2xl lg:text-5xl font-bold leading-tight">
        {{ carbon_get_the_post_meta('home_title') }}
      </h1>

      <p class="leading-normal text-lg lg:text-2xl mb-8">
        {{ carbon_get_the_post_meta('home_subtitle') }}
      </p>

      <button
        class="cursor-pointer mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
        {{ carbon_get_the_post_meta('cta_text') }}
      </button>
    </div>

    <div class="w-full md:w-3/5 py-6 text-center">
      @include('components.image', ['field_prefix' => 'home_banner'])
    </div>
  </div>

</div>