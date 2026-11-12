@extends('layouts.app')
@section('title', "Today's Tasks")
@section('breadcrumb', 'Dashboard')
@section('content')
<div class="page-heading"><div><div class="eyebrow">MAKE ROOM FOR A PRODUCTIVE DAY</div><h1>Today's Tasks<span class="heading-dot">.</span></h1><p>Welcome back. Here’s what’s on your schedule today.</p></div><span class="date-pill"><x-icon name="calendar" size="17"/> {{ $today->format('l, F j') }}</span></div>
<section class="hero" aria-labelledby="hero-title">
    <div class="hero-copy"><span class="hero-label"><span></span> YOUR DAILY OVERVIEW</span><h2 id="hero-title">A clear day starts<br>with a clear plan.</h2><p>You have {{ $pendingCount }} {{ Str::plural('task', $pendingCount) }} left today.<br>Take it one step at a time. You’ve got this.</p><a class="hero-link" href="#today-schedule">See today's schedule <x-icon name="arrow" size="17"/></a></div>
    <div class="hero-progress"><div class="progress-ring" style="--progress: {{ $completionRate }}%" role="img" aria-label="{{ $completionRate }} percent of today's tasks completed"><div><strong>{{ $completionRate }}<span>%</span></strong><small>completed</small></div></div><p>{{ $completedCount }} of {{ $tasks->count() }} tasks done</p></div>
</section>
<section class="stats" aria-label="Today's task statistics">
    <article class="stat-card"><div><span class="stat-label">Today's tasks</span><strong>{{ $tasks->count() }}</strong><small>Scheduled for today</small></div><span class="stat-icon indigo"><x-icon name="tasks" size="23"/></span></article>
    <article class="stat-card"><div><span class="stat-label">Pending</span><strong>{{ $pendingCount }}</strong><small>Ready for your attention</small></div><span class="stat-icon amber"><x-icon name="clock" size="23"/></span></article>
    <article class="stat-card"><div><span class="stat-label">Completed</span><strong>{{ $completedCount }}</strong><small>One step further along</small></div><span class="stat-icon green"><x-icon name="check" size="23"/></span></article>
</section>
<section class="panel" id="today-schedule" aria-labelledby="schedule-title"><div class="panel-heading"><div><h2 id="schedule-title">On your schedule <span class="count-pill">{{ $tasks->count() }}</span></h2><p>Only tasks scheduled for today, {{ $today->format('F j') }}.</p></div><a class="text-link" href="{{ route('tasks.index') }}">View all tasks <x-icon name="arrow" size="16"/></a></div><x-task-table :tasks="$tasks" empty-title="A little breathing room" empty-message="No tasks are scheduled for today. Enjoy your clear schedule, or view all tasks to see what’s coming up."/><div class="panel-foot"><span class="tiny-dot"></span> Today’s view · {{ config('app.timezone') }}</div></section>
<div class="daily-note"><x-icon name="spark" size="18"/><p>Progress is built one task at a time. <strong>Make today count.</strong></p></div>
@endsection
