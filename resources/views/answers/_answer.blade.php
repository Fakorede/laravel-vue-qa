<answer :answer="{{ $answer }}" inline-template>
    <div class="media divider">
        {{-- vote contols --}}
        @include('shared._vote', [
            'model' => $answer
        ])
    
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea name="body" v-model="body" class="form-control" rows="10" required></textarea>
                </div>
                <button class="btn btn-sm btn-outline-primary" type="submit" :disabled="isInvalid">Update</button>
                <button class="btn btn-sm btn-outline-secondary" type="button" @click="cancel">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can ('update', $answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan
                            @can ('delete', $answer)
                                <form class="form-delete" method="post" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        {{-- @include('shared._author', [
                            'model' => $answer,
                            'label' => 'answered'
                        ]) --}}
                        <user-info :model="{{ $answer }}" label="answered"></user-info>
                    </div>
                </div>    
            </div>                            
        </div>
    </div>
</answer>