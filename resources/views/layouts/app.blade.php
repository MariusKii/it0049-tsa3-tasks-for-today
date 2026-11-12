<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#5145cd">
    <meta name="description" content="A clear view of your day. Organize and view scheduled tasks with Tasks for Today Management System.">
    <title>@yield('title') · {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<a class="skip-link" href="#main-content">Skip to content</a>
<aside class="sidebar">
    <a class="brand" href="{{ route('dashboard') }}" aria-label="Tasks for Today home">
        <span class="brand-mark"><x-icon name="check" size="23"/></span>
        <span>Tasks for Today<small>A little more organized.</small></span>
    </a>
    <div class="nav-caption">WORKSPACE</div>
    <nav aria-label="Main navigation">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif><x-icon name="dashboard"/> Dashboard</a>
        <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" @if(request()->routeIs('tasks.index')) aria-current="page" @endif><x-icon name="tasks"/> All Tasks</a>
        <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" @if(request()->routeIs('profile')) aria-current="page" @endif><x-icon name="user"/> Profile</a>
        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif><x-icon name="info"/> About</a>
    </nav>
    <div class="sidebar-note"><span class="note-icon"><x-icon name="spark"/></span><strong>Small steps. Real progress.</strong><p>A clear plan makes room for what matters.</p></div>
    <div class="sidebar-bottom"><span class="workspace-avatar">T</span><span>Your workspace<small>Tasks for Today</small></span><span class="online-dot" aria-hidden="true"></span></div>
</aside>
<div class="app-shell">
    <header class="topbar"><span class="breadcrumb">Workspace <span>/</span> <strong>@yield('breadcrumb')</strong></span><span class="topbar-date"><x-icon name="calendar" size="17"/> {{ now()->format('M d, Y') }}</span></header>
    <main id="main-content" tabindex="-1">@yield('content')</main>
    <footer><span>{{ config('app.name') }}</span><span>IT0049 · TSA3 <span class="footer-dot">•</span> Built with Laravel</span></footer>
</div>
</body>
</html>
