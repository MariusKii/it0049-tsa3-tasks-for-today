@extends('layouts.app')
@section('title', 'My Profile')
@section('breadcrumb', 'Profile')
@section('content')
<div class="page-heading"><div><div class="eyebrow">THE PERSON BEHIND THE PLAN</div><h1>My Profile<span class="heading-dot">.</span></h1><p>Your personal details, all in one place.</p></div></div>
@if($user)
<section class="profile-card panel" aria-labelledby="profile-name"><div class="profile-cover"><span>YOUR WORKSPACE PROFILE</span><x-icon name="spark" size="50"/></div><div class="profile-body"><div class="profile-avatar" aria-hidden="true">{{ Str::of($user->full_name)->explode(' ')->filter()->take(2)->map(fn ($part) => Str::upper(Str::substr($part, 0, 1)))->implode('') }}</div><div class="profile-intro"><h2 id="profile-name">{{ $user->full_name }}</h2><p>Workspace profile</p></div><div class="profile-details"><div><span><x-icon name="user" size="18"/> Full name</span><strong>{{ $user->full_name }}</strong></div><div><span><x-icon name="code" size="18"/> Username</span><strong>{{ $user->username }}</strong></div><div><span><x-icon name="mail" size="18"/> Email address</span><strong>{{ $user->email }}</strong></div></div>
@if($user->username === 'CHANGE_ME' || $user->email === 'change-me@example.invalid')<div class="placeholder-note"><x-icon name="info" size="18"/><p>The username and email are editable placeholders. Your personal details have not been supplied yet.</p></div>@endif
</div></section>
@else
<section class="panel"><div class="empty-state"><span class="empty-icon"><x-icon name="user" size="30"/></span><h2>No profile available yet</h2><p>Your profile will appear here once it has been added to the database.</p></div></section>
@endif
@endsection
