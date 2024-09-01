@php
   use App\Enums\TaskStatus;
@endphp

<x-app-layout>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         {{ __('View Project') }}
      </h2>
   </x-slot>

   <div class="pt-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
               <h2 class="mb-5 text-xl font-semibold underline">Project Details</h2>
               <p class="mb-2">
                  <span class="font-semibold">Name:</span>
                  <span class="text-sm">{{ $project->name }}</span>
               </p>
               <p>
                  <span class="font-semibold">Description:</span>
                  <span class="text-sm">{{ $project->name }}</span>
               </p>
               <p>
                  <span class="font-semibold">Created at:</span>
                  <span class="text-sm">{{ $project->created_at->diffForHumans() }}</span>
               </p>
               <p>
                  <span class="font-semibold">Updated at:</span>
                  <span class="text-sm">{{ $project->updated_at->diffForHumans() }}</span>
               </p>
            </div>
         </div>
      </div>
   </div>

   <div class="pb-12 mt-5">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
               <h2 class="mb-5 text-xl font-semibold underline">Associated Tasks</h2>
               <div x-data="{ tasks: {{ $tasks }} }"
                  class="relative overflow-x-auto shadow-md sm:rounded-lg">
                  <div class="pb-4 bg-white dark:bg-gray-900">
                     <div class="relative mt-1">
                        <form action=""
                           method="get"
                           class="flex items-center gap-2">
                           <select name="status"
                              class="bg-gray-50 w-1/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <option selected
                                 value>Choose status</option>
                              @foreach (TaskStatus::cases() as $case)
                                 <option value="{{ $case->value }}"
                                    selected="{{ request('status') === $case->value }}">
                                    {{ strtoupper($case->value) }}</option>
                              @endforeach
                           </select>
                           <button type="submit"
                              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none mt-1">Filter</button>
                        </form>
                     </div>
                  </div>
                  <table
                     class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                     <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                           <th scope="col"
                              class="px-6 py-3">
                              Task name
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Description
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Status
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Created at
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Action
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                        <template x-for="task in tasks"
                           :key="task.id">
                           <tr
                              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                              <th x-text="task.name"
                                 scope="row"
                                 class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              </th>
                              <td x-text="task.description"
                                 class="px-6 py-4">
                              </td>
                              <td class="px-6 py-4">
                                 <span x-text="task.status"
                                    class="text-xs font-semibold me-2 px-2.5 py-0.5 rounded uppercase text-nowrap"
                                    :class="{
                                        'bg-red-100 text-red-800': task
                                            .status === 'todo',
                                        'bg-blue-100 text-blue-800 ': task
                                            .status === 'in progress',
                                        'bg-green-100 text-green-800': task
                                            .status === 'done'
                                    }">

                                 </span>
                              </td>
                              <td x-text="new Date(task.created_at).toLocaleString()"
                                 class="px-6 py-4">
                              </td>
                              <td class="px-6 py-4">
                                 <a href="{{ route('projects.show', ['project' => $project]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Show</a>
                              </td>
                           </tr>
                        </template>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>
