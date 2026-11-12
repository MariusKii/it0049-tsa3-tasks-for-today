@extends('layouts.app')
@section('title', 'All Tasks')
@section('breadcrumb', 'All Tasks')
@section('content')
<div class="page-heading"><div><div class="eyebrow">THE BIG PICTURE</div><h1>All Tasks<span class="heading-dot">.</span></h1><p>Every task, in one place. A clear view of what’s done and what’s ahead.</p></div><span class="date-pill"><x-icon name="tasks" size="17"/> {{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }} in total</span></div>
<div class="info-banner"><span class="stat-icon indigo"><x-icon name="calendar" size="24"/></span><div><strong>Your schedule, at a glance</strong><p>Tasks are arranged from the earliest date to the latest, across your entire schedule.</p></div></div>
<section class="panel" aria-labelledby="all-tasks-title"><div class="panel-heading"><div><h2 id="all-tasks-title">Task overview <span class="count-pill">{{ $tasks->count() }}</span></h2><p>Past, present, and upcoming tasks.</p></div><span class="sort-label"><x-icon name="calendar" size="15"/> Date · earliest first</span></div><x-task-table :tasks="$tasks" empty-title="Your schedule starts here" empty-message="There are no tasks in the database yet. Scheduled tasks will appear here once available."/><div class="panel-foot"><span class="tiny-dot"></span> Showing all {{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}</div></section>
@endsection
