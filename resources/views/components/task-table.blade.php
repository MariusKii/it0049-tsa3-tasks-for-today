@props(['tasks', 'emptyTitle' => 'No tasks yet', 'emptyMessage' => 'Your scheduled tasks will appear here.'])
@if($tasks->isEmpty())
<div class="empty-state"><span class="empty-icon"><x-icon name="calendar" size="30"/></span><h3>{{ $emptyTitle }}</h3><p>{{ $emptyMessage }}</p></div>
@else
<div class="table-scroll" role="region" aria-label="Scheduled tasks" tabindex="0">
<table>
    <caption class="sr-only">Scheduled tasks with status and date</caption>
    <thead><tr><th scope="col">Task name</th><th scope="col">Status</th><th scope="col">Scheduled date</th></tr></thead>
    <tbody>
    @foreach($tasks as $task)
    <tr>
        <td><div class="task-title"><span class="task-state {{ $task->status === 'completed' ? 'is-complete' : '' }}" aria-hidden="true">@if($task->status === 'completed')<x-icon name="check" size="14"/>@endif</span><span>{{ $task->title }}</span></div></td>
        <td><span @class(['badge', 'badge-completed' => $task->status === 'completed', 'badge-pending' => $task->status === 'pending'])><span class="badge-dot" aria-hidden="true"></span>{{ ucfirst($task->status) }}</span></td>
        <td><span class="task-date"><x-icon name="calendar" size="15"/><time datetime="{{ $task->task_date->toDateString() }}">{{ $task->task_date->format('M d, Y') }}</time></span></td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
@endif
