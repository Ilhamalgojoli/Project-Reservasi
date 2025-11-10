@extends('layout.layout')

@php
    $title = 'Dashboard';
    $script = '
         <script src="' . asset('assets/js/data-table.js') . '" defer></script>
    ';
@endphp

@section('content')
    <div class="lg:col-span-12 2xl:col-span-8 mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
    </div>

    <div class="flex flex-col space-y-8">
        <div class="grid grid-cols-[repeat(auto-fit,minmax(200px,4fr))] justify-between gap-5">
            <div class="bg-[#2CCA49] text-white rounded-xl py-8
            shadow-lg flex items-center justify-center space-x-4">
                <div class="flex flex-col text-center items-center ">
                    <div class="flex flex-row gap-2 items-center">
                        <img src="{{ asset("/assets/basila_images/building.png") }}" class="w-12 mb-3"/>
                        <h2 class="text-4xl text-white font-bold leading-tight">13</h2>
                    </div>
                    <p class="text-2xl font-bold">Ruang Tersedia</p>
                </div>
            </div>

            <div class="bg-[#BDBDBD] text-white rounded-xl py-8
            shadow-lg flex items-center justify-center space-x-4">
                <div class="flex flex-col text-center items-center ">
                    <div class="flex flex-row gap-2 items-center">
                        <img src="{{ asset("/assets/basila_images/building.png") }}" class="w-12 mb-3"/>
                        <h2 class="text-4xl text-white font-bold leading-tight">20</h2>
                    </div>
                    <p class="text-2xl font-bold">Ruang Sedang Perbaikan</p>
                </div>
            </div>

            <div class="bg-[#e51411] text-white rounded-xl py-8
            shadow-lg flex items-center justify-center space-x-4">
                <div class="flex flex-col text-center items-center ">
                    <div class="flex flex-row gap-2 items-center">
                        <img src="{{ asset("/assets/basila_images/disable-building.png") }}" class="w-16 mb-3"/>
                        <h2 class="text-4xl text-white font-bold leading-tight">42</h2>
                    </div>
                    <p class="text-2xl font-bold">Ruang Terpakai</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <div class="card-body col-span-12 bg-white rounded-xl p-8 shadow-lg space-y-4">
                <h1 class="text-2xl text-shadow">Jadwal Akademik</h1>
                <div class="overflow-x-auto">
                    <table id="selection-table-1" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                        <thead>
                        <tr>
                            <th scope="col">Users</th>
                            <th scope="col">Registered On</th>
                            <th scope="col">Plan</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user1.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Dianne Russell</h6>
                                        <span class="text-sm text-secondary-light font-medium">redaniel@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Free</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user2.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Wade Warren</h6>
                                        <span class="text-sm text-secondary-light font-medium">xterris@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Basic</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user3.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Albert Flores</h6>
                                        <span class="text-sm text-secondary-light font-medium">seannand@mail.ru</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Standard</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user4.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Bessie Cooper </h6>
                                        <span class="text-sm text-secondary-light font-medium">igerrin@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Business</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user5.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Arlene McCoy</h6>
                                        <span class="text-sm text-secondary-light font-medium">fellora@mail.ru</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Enterprise</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <div class="card-body col-span-12 bg-white rounded-xl p-8 shadow-lg space-y-4">
                <h1 class="text-2xl text-shadow">Jadwal Non-Akademik</h1>
                <div class="overflow-x-auto">
                    <table id="selection-table-2" class="table bordered-table sm-table mb-0 table-auto">
                        <thead>
                        <tr>
                            <th scope="col">Users</th>
                            <th scope="col">Registered On</th>
                            <th scope="col">Plan</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user1.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Dianne Russell</h6>
                                        <span class="text-sm text-secondary-light font-medium">redaniel@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Free</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user2.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Wade Warren</h6>
                                        <span class="text-sm text-secondary-light font-medium">xterris@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Basic</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user3.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Albert Flores</h6>
                                        <span class="text-sm text-secondary-light font-medium">seannand@mail.ru</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Standard</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user4.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Bessie Cooper </h6>
                                        <span class="text-sm text-secondary-light font-medium">igerrin@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Business</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/users/user5.png') }}" alt=""
                                         class="w-10 h-10 rounded-full shrink-0 me-2 overflow-hidden">
                                    <div class="grow">
                                        <h6 class="text-base mb-0 font-medium">Arlene McCoy</h6>
                                        <span class="text-sm text-secondary-light font-medium">fellora@mail.ru</span>
                                    </div>
                                </div>
                            </td>
                            <td>27 Mar 2025</td>
                            <td>Enterprise</td>
                            <td class="text-center">
                            <span
                                class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-6
                                 py-1.5 rounded-full font-medium text-sm">Active</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
