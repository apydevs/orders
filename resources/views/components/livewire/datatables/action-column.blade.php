<div class=" flex flex-row justify-between items-center p-4 w-24">
    @isset ( $viewLink )
    @endif

    @isset ( $editLink )

                <a wire:navigate href="{{$editLink}}"
                   class="" x-ref="content">
                    <x-svg-icon   iconName="edit" classNames="w-4 h-4"  />
                </a>

    @endif



    @isset ( $deleteLink )
        <form
            action="{{ $deleteLink }}"
            class="d-inline"
            method="POST"
            x-data
            @submit.prevent="if (confirm('Are you sure you want to delete this user?')) $el.submit()"
        >
            @method('DELETE')
            @csrf
            <button type="submit" class="">
                <x-svg-icon iconName="delete" classNames="w-4 h-4 mt-1 "  />
            </button>
        </form>
    @endif

</div>
