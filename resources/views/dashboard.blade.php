    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12" id="app">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @{{message}}
                    </div>
                </div>
            </div>
            <div class="mt-4 text-right max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-text-input @input="searchData()" v-model="search" placeholder="Search with Email" type="text" class="mt-1 block w-full" />

                <x-primary-button @click="isCreate?onCancel():onShowCreateForm()" class="mt-2">
                    @{{isCreate? "Cancel": "Create New User"}}</x-primary-button>

            </div>
            <!-- Create Form -->
            <div v-if="isCreate" class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">

                        <div>
                            <x-input-label :value="__('Name')" />
                            <x-text-input v-model="newUser.name" type="text" class="mt-1 block w-full" />
                            <label id="name" class="mt-2 text-sm text-red-600 space-y-1 mt-2" />
                        </div>

                        <div>
                            <x-input-label :value="__('Email')" />
                            <x-text-input v-model="newUser.email" type="text" class="mt-1 block w-full" />
                            <label id="email" class="mt-2 text-sm text-red-600 space-y-1 mt-2" />
                        </div>

                        <div>
                            <x-input-label :value="__('Contact Number')" />
                            <x-text-input v-model="newUser.contact" type="text" class="mt-1 block w-full" />
                            <label id="contact" class="mt-2 text-sm text-red-600 space-y-1 mt-2" />
                        </div>

                        <div>
                            <x-input-label :value="__('Home Address')" />
                            <x-text-input v-model="newUser.address" type="text" class="mt-1 block w-full" />
                            <label id="address" class="mt-2 text-sm text-red-600 space-y-1 mt-2" />
                        </div>

                        <div>
                            <x-input-label :value="__('Password')" />
                            <x-text-input v-model="newUser.password" type="password" class="mt-1 block w-full" />
                            <label id="password" class="mt-2 text-sm text-red-600 space-y-1 mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button @click="onCreate">{{ __('Save') }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Table Data -->
            <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <div
                        class="min-w-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
                        <div class="w-full lg:w-5/6">
                            <!-- Loading -->
                            <div v-if="loading" role="status" class="text-center mt-4">
                                <span>Loading...</span>
                            </div>
                            <div class="bg-white shadow-md rounded my-6" v-if="!loading">
                                <meta name="csrf-token" content="{{ csrf_token() }}">




                                <!-- Table -->
                                <table class="min-w-max w-full table-auto" >
                                    <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-4 px-6 text-left">#</th>
                                            <th class="py-4 px-6 text-left">Name</th>
                                            <th class="py-4 px-6 text-left">Email</th>
                                            <th class="py-4 px-6 text-left">Contact</th>
                                            <th class="py-4 px-6 text-center">Address</th>
                                            <th class="py-4 px-6 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        <tr class="table-height border-b border-gray-200 hover:bg-gray-100"
                                            v-for="(item,index) in data.data">
                                            <td class="py-4 px-6 text-left whitespace-nowrap">
                                                @{{++index}}
                                            </td>
                                            <td class="py-4 px-6 text-left whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="mr-2">
                                                        <img class="w-6 h-6 rounded-full"
                                                            src="https://randomuser.me/api/portraits/men/1.jpg" />
                                                    </div>
                                                    <span v-if="selectedIndex!=index"
                                                        class="font-medium">@{{item.name}}</span>
                                                    <input v-else
                                                        class="shadow appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        type="text" placeholder="Name" v-model="selectedData.name">

                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-left">
                                                <div class="flex items-center">
                                                    <span v-if="selectedIndex!=index"
                                                        class="font-medium">@{{item.email}}</span>
                                                    <input v-else
                                                        class="shadow appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        type="text" placeholder="Email" v-model="selectedData.email">
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-left">
                                                <div class="flex items-center">
                                                    <span v-if="selectedIndex!=index"
                                                        class="font-medium">@{{item.contact}}</span>
                                                    <input v-else
                                                        class="shadow appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                        type="text" placeholder="Contact" v-model="selectedData.contact">
                                                </div>
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <span v-if="selectedIndex!=index"
                                                    class="font-medium">@{{item.address}}</span>
                                                <input v-else
                                                    class="shadow appearance-none border rounded py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                    type="text" placeholder="Address" v-model="selectedData.address">
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex ">
                                                    <div v-if="selectedIndex!=index"
                                                        class=" mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        
                                                        <button @click="onEdit(item,index)" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border font-semibold text-xs text-white uppercase  hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Edit</button>
                                                    </div>
                                                    <div v-if="selectedIndex!=index"
                                                        class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <button @click="onDelete(item,index)" type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Delete</button>
                                                    </div>
                                                <div v-if="isEdit && selectedIndex==index"
                                                    class="mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <button @click="onUpdate()" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border font-semibold text-xs text-white uppercase  hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update</button>
                                                    </button>
                                                </div>
                                                <div v-if="isEdit && selectedIndex==index"
                                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <button @click="onCancel()" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border font-semibold text-xs text-white uppercase  hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Cancel</button>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            <!-- Pagination -->
                        </div>
                        <div class="mt-2 mb-4 text-right">
                            <nav>
                                <ul class="inline-flex -space-x-px">
                                    <li v-for="page in data.links">
                                        <a @click="fetchData(page.url)" href="#" class="px-3 py-2 ml-0 leading-tight text-gray-500  border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" :class="page.active?'bg-indigo':'bg-white'" v-html="page.label"></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </x-app-layout>


    <script>
        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    loading: false,
                    search: '',
                    data: [],
                    message: 'You\'re logged in!',
                    // Edit
                    isEdit: false,
                    selectedData: {},
                    selectedIndex: 0,
                    // Create
                    isCreate: false,
                    newUser: {
                        name: '',
                        address: '',
                        contact: '',
                        email: '',
                        password: ''
                    },
                    validationMessages: {}
                }
            },
            created: function () {
                this.fetchData();
            },
            methods: {
                searchData(){
                    this.fetchData(null,this.search)
                },
                fetchData: function (url,search) {
                    if(!url){
                        this.loading = true
                    }
                    console.log('fetchData')
                    this.data = [{
                        name: 'test',
                        contact: '0212221212'
                    }]

                    var link = url? url : '{{ route('getall') }}'

                    if(search){
                        link = link + "?search=" + search
                    }

                    fetch(link)
                        .then((response) => response.json())
                        .then((data) => {
                            if(!url){
                                this.loading = false
                            }
                            this.data = data
                            console.log(data)
                        });
                },
                onEdit(item, index) {
                    this.isEdit = true;
                    this.selectedData = item
                    this.selectedIndex = index
                },
                onShowCreateForm() {
                    this.isCreate = true;
                },
                onCreate() {
                    // this.isCreate = true;
                    console.log("oncreate")
                    fetch("{{ route('oncreate') }}", {
                            method: "POST", // or 'PUT'
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.newUser),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            console.log("Success:", data);
                            if (data.status) {
                                this.message = "successfully created";
                                this.fetchData();
                                this.onCancel();
                            } else {
                                this.validationMessages = data.messages
                                this.setMessages(data.messages)
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            this.validationMessages = error.messages
                            this.setMessages(data.messages)
                        });
                },
                setMessages(date) {
                    document.getElementById('name').innerText = "";
                    document.getElementById('email').innerText = "";
                    document.getElementById('contact').innerText = "";
                    document.getElementById('address').innerText = "";
                    document.getElementById('password').innerText = "";

                    for (const key in this.validationMessages) {
                        console.log(`${key}: ${this.validationMessages[key]}`);
                        var element = document.getElementById(key)
                        element.innerText = this.validationMessages[key]
                    }
                },
                onUpdate() {
                    console.log("onupdate")
                    fetch("{{ route('onupdate') }}", {
                            method: "POST", // or 'PUT'
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.selectedData),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            console.log("Success:", data);
                            if (data.status) {
                                this.message = "successfully updated";
                                this.fetchData();
                                this.onCancel();
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });
                },
                onCancel() {
                    console.log("onCancel")
                    this.isEdit = false
                    this.selectedData = {}
                    this.selectedIndex = 0
                    this.isCreate = false
                },
                onDelete(item, index) {
                    console.log("ondelete")

                    fetch("{{ route('ondelete') }}", {
                            method: "POST", // or 'PUT'
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(item),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            console.log("Success:", data);
                            if (data.status) {
                                this.message = "successfully deleted";
                                this.fetchData();
                                this.onCancel();
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });
                },
            }
        }).mount('#app')

    </script>
