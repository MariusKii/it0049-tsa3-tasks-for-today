@extends('layouts.app')
@section('title', 'About the Application')
@section('breadcrumb', 'About')
@section('content')
<div class="page-heading"><div><div class="eyebrow">A LITTLE CONTEXT</div><h1>About the Application<span class="heading-dot">.</span></h1><p>A simple way to bring a little more clarity to every day.</p></div></div>
<section class="about-hero"><span class="brand-mark large"><x-icon name="check" size="34"/></span><span class="eyebrow">BUILT FOR A MORE ORGANIZED DAY</span><h2>Tasks for Today<br>Management System</h2><p>A focused workspace to help you organize and view scheduled tasks. See what needs your attention today, explore your full schedule, and keep your day moving forward.</p><a class="button" href="{{ route('dashboard') }}">Back to your day <x-icon name="arrow" size="17"/></a></section>
<div class="about-grid"><section class="panel about-detail"><span class="section-icon"><x-icon name="user" size="22"/></span><h2>Behind the application</h2><dl><div><dt>Developer</dt><dd>Marius De Asis</dd></div><div><dt>Course</dt><dd>IT0049 – Web System Technologies</dd></div><div><dt>Assessment</dt><dd>Technical Summative Assessment 3</dd></div></dl></section><section class="panel about-detail"><span class="section-icon"><x-icon name="code" size="22"/></span><h2>Built with Laravel</h2><p>A database-driven application following the Model–View–Controller architecture.</p><ul class="tech-tags"><li>Laravel</li><li>PHP</li><li>Blade</li><li>Eloquent ORM</li><li>Database migrations</li><li>Database seeders</li></ul></section></div>
@endsection
