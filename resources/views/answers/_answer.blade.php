<answer :answer="{{ $answer }}" inline-template>
    <div class="media divider">
        {{-- vote contols --}}
        <vote :model="{{ $answer }}" name="answer"></vote>
    
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
                                <button @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
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