<div class="card" v-if="editing">
    <div class="card-header bg-white">
        <div class="level">
            <input type="text" class="form-control" v-model="form.title">
        </div>


    </div>

    <div class="card-body bg-white">
        <div class="form-group">
            <wysiwyg v-model="form.body" :value="form.body"></wysiwyg>
        </div>
    </div>

    <div class="card-footer bg-white">
        <div class="level">
            <button type="button" class="btn btn-secondary btn-sm level-item" @click="editing = true" v-show="! editing">Edit</button>
            <button type="button" class="btn btn-primary btn-sm level-item" @click="update">Update</button>
            <button type="button" class="btn btn-secondary btn-sm level-item" @click="resetForm">Cancel</button>

            @can ('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-auto">
                    @csrf
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger btn-sm">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

<div class="card" v-else>
    <div class="card-header bg-white">
        <div class="level">

            <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="50" height="50" class="mr-1">

            <span class="flex">
                <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a> posted: <span v-text="title"></span>
            </span>
        </div>
    </div>

    <div class="card-body bg-white" v-html="body">
    </div>

    <div class="card-footer bg-white" v-if="authorize('owns', thread)">
        <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
    </div>
</div>
