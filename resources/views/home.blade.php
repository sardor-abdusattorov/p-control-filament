@extends('layouts.main')

  @section('title', 'Главная')

@section('content')
  <section class="home-hero">
    <div class="container">
      <h1 class="home-hero__title">Сайт компании «Пример»</h1>
      <p class="home-hero__subtitle">
        Мы разрабатываем современные веб‑решения для бизнеса и частных лиц.
      </p>
      <a href="#" class="home-hero__button">Подробнее о нас</a>
    </div>
  </section>

  <section class="home-about">
    <div class="container">
      <h2 class="home-about__title">О компании</h2>
      <p class="home-about__text">
        Наша команда специализируется на создании адаптивных и удобных сайтов, интернет‑магазинов и корпоративных порталов. Работаем на рынке IT‑услуг с 2015 года.
      </p>
    </div>
  </section>

  <section class="home-services">
    <div class="container">
      <h2 class="home-services__title">Наши услуги</h2>
      <ul class="home-services__list">
        <li class="home-services__item">Разработка сайтов</li>
        <li class="home-services__item">Дизайн и брендинг</li>
        <li class="home-services__item">SEO-продвижение</li>
        <li class="home-services__item">Поддержка и сопровождение</li>
      </ul>
    </div>
  </section>

  <section class="home-contacts">
    <div class="container">
      <h2 class="home-contacts__title">Связаться с нами</h2>
      <p class="home-contacts__text">
        Email: info@primer.com<br>
        Телефон: +998 90 000-00-00
      </p>
    </div>
  </section>
@endsection
