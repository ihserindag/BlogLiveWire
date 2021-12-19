<div class="container mx-auto mt-2">

    <div class="flex content-center m-2 p-2">
        <x-jet-button wire:click="showCreatePostModal" class="bg-green-500">
           Create Post
        </x-jet-button>
    </div>
    @if (session()->has('message'))

    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
        <p>{{ session('message') }}</p>
      </div>
<br>
    @endif

    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Id</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Title</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Image</th>
                  <th scope="col" class="relative px-6 py-3">Edit</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr></tr>

                    @foreach ($posts as $post)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($post->active)
                            active
                            @else
                            Not active
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <img class="w-8 h-8 rounded-full" src="{{ asset('storage/photos/'.$post->image) }}" />
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                          <x-jet-button class="bg-blue-500" wire:click="showEditPostModal({{ $post->id }})">Edit</x-jet-button>


                          <x-jet-button class="bg-red-500" wire:click="deletePost({{ $post->id }})">Delete</x-jet-button>

                        </td>
                      </tr>
                    @endforeach

                <!-- More items... -->
              </tbody>
            </table>
            <div class="m-2 p-2">
                {{ $posts->links() }}
            </div>
          </div>
        </div>
      </div>

      <x-jet-dialog-modal wire:model="showModalForm">

        <x-slot name="title">


            @if($postId)
            Update Post
            @else
            Create Post
            @endif

        </x-slot>
        <x-slot name="content">
            <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                <form enctype="multipart/form-data">
                  <div class="sm:col-span-6">
                    <label for="title" class="block text-sm font-medium text-gray-700"> Post Title </label>
                    <div class="mt-1">
                      <input type="text" id="title" wire:model.lazy="title" name="title" class="block w-full transition duration-150 ease-in-out appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('title') <span class="error">{{ $message }}</span>@enderror


                  </div>
                  <div class="sm:col-span-6">
                    <div class="w-full m-2 p-2">
                        @if($newImage)
                        Post Photo:
                        <img src="{{ asset('storage/photos/'.$newImage) }}" alt="">
                        @endif

                        @if($image)
                        Photo Preview:
                        <img src="{{ $image->temporaryUrl() }}" alt="">
                        @endif
                    </div>
                    <label for="title" class="block text-sm font-medium text-gray-700"> Post Image </label>
                    <div class="mt-1">
                      <input type="file" id="image" wire:model="image" name="image" class="block w-full transition duration-150 ease-in-out appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    @error('image') <span class="error">{{ $message }}</span>@enderror
                  </div>
                  <div class="sm:col-span-6 pt-5">
                    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                    <div class="mt-1">
                      <textarea id="body" rows="3" wire:model.lazy="body" class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    @error('body') <span class="error">{{ $message }}</span>@enderror
                  </div>
                </form>
              </div>

        </x-slot>
        <x-slot name="footer">


            @if($postId)
            <x-jet-button wire:click="updatePost">
                Update
            </x-jet-button>
            @else
            <x-jet-button wire:click="storePost">
                Store
            </x-jet-button>
            @endif
        </x-slot>


      </x-jet-dialog-modal>

</div>

