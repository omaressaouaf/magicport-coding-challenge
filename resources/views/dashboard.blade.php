<x-app-layout>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         {{ __('Dashboard') }}
      </h2>
   </x-slot>

   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
               <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                  <div class="pb-4 bg-white">
                     <label for="table-search"
                        class="sr-only">Search</label>
                     <div class="relative mt-1">
                        <div
                           class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                           <svg class="w-4 h-4 text-gray-500 "
                              aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg"
                              fill="none"
                              viewBox="0 0 20 20">
                              <path stroke="currentColor"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 stroke-width="2"
                                 d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                           </svg>
                        </div>
                        <form action=""
                           method="get">
                           <input type="text"
                              id="table-search"
                              class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Search by name"
                              name="name"
                              value="{{ request('name') }}">
                        </form>
                     </div>
                  </div>
                  <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                     <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                           <th scope="col"
                              class="px-6 py-3">
                              Project name
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Description
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Created at
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Updated at
                           </th>
                           <th scope="col"
                              class="px-6 py-3">
                              Action
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($projects as $project)
                           <tr class="bg-white border-b hover:bg-gray-50 :bg-gray-600">
                              <th scope="row"
                                 class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                 {{ $project->name }}
                              </th>
                              <td class="px-6 py-4">
                                 {{ $project->description }}
                              </td>
                              <td class="px-6 py-4">
                                 {{ $project->created_at->diffForHumans() }}
                              </td>
                              <td class="px-6 py-4">
                                 {{ $project->updated_at->diffForHumans() }}
                              </td>
                              <td class="px-6 py-4">
                                 @can('has-permission', 'view project')
                                    <a href="{{ route('projects.show', ['project' => $project]) }}"
                                       class="font-medium text-blue-600 underline">Show</a>
                                 @endcan
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</x-app-layout>
