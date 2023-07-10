<div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-align="start">
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-dark sidebar-left simplebar" data-simplebar>
            <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex d-flex align-items-center text-underline-0 text-body">
                    <span class="mr-3">
                        <img src="{{ asset('img/logo/icon.png') }}" width="43" height="43" alt="avatar">
                    </span>
                    <span class="flex d-flex flex-column">
                        <strong style="font-size: 1.125rem;">KUIS</strong>
                        <small class="text-muted text-uppercase" style="color: rgba(255,255,255,.54)">Interaktif</small>
                    </span>
                </a>
            </div>
        
            <div class="tab-content">
                <div id="sm-menu" class="tab-pane show active" role="tabpanel" aria-labelledby="sm-menu-tab">
                    <ul class="sidebar-menu flex">
                        <li class="sidebar-menu-item @if($id_page == 1) active @endif">
                            <a class="sidebar-menu-button" href="{{ route('dashboard') }}">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-desktop" style="font-size: 15px"></i>
                                <span style="font-weight: 300">Dashboard</span>
                            </a>
                        </li>

                    @if (auth()->user()->level == 'admin')
                        
                    <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        Mengelola Pengguna
                    </p>

                    <li class="sidebar-menu-item @if($id_page == 2) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('dosen') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-user-secret" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Dosen</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item @if($id_page == 3) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('mahasiswa') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-users" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Mahasiswa</span>
                        </a>
                    </li>

                    @endif

                    <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        @if (auth()->user()->level == 'admin' || auth()->user()->level == 'dosen')
                            Rekap Kelas
                        @else
                            Rekap Kelas Quiz
                        @endif
                    </p>

                     <li class="sidebar-menu-item @if($id_page == 15) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('assesment_recap') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-rocket" style="font-size: 15px"></i>
                            <span style="font-weight: 300">
                                Assessment Recap
                            </span>
                        </a>
                    </li>

                    <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        @if (auth()->user()->level == 'admin' || auth()->user()->level == 'dosen')
                            Mengelola Akademik
                        @else
                            Kelas Saya
                        @endif
                    </p>

                    <li class="sidebar-menu-item @if($id_page == 4) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('modul') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-book" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Modul</span>
                        </a>
                    </li>

                    {{-- <li class="sidebar-menu-item @if($id_page == 17) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('modul_video') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-file-video" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Modul Video</span>
                        </a>
                    </li> --}}

                    {{-- <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        @if (auth()->user()->level == 'admin' || auth()->user()->level == 'dosen')
                            Class Management
                        @else
                            My Class
                        @endif
                    </p> --}}

                    

                    @if (auth()->user()->level == 'admin')
                    <li class="sidebar-menu-item @if($id_page == 5) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('matkul') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-graduation-cap" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Mata Kuliah</span>
                        </a>
                    </li>
                   
                    <li class="sidebar-menu-item @if($id_page == 6) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('kelas') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-address-book" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Kelas</span>
                        </a>
                    </li>
                   
                    <li class="sidebar-menu-item @if($id_page == 7) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('semester') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-star" style="font-size: 15px"></i>
                            <span style="font-weight: 300">Semester</span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->level == 'dosen')
                    
                    <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        Quiz Management
                    </p>
                        
                    <li class="sidebar-menu-item @if($id_page == 10) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('quiz') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-rocket" style="font-size: 15px"></i>
                            <span style="font-weight: 300">
                                Manage Quiz
                            </span>
                        </a>
                    </li>

                    @endif
                    @if (auth()->user()->level == 'mahasiswa')
                    <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        Quizzes
                    </p>
      
                    <li class="sidebar-menu-item @if($id_page == 11) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('multiple_choice') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-circle" style="font-size: 15px"></i>
                            <span style="font-weight: 300">
                                Multiple Choice
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item @if($id_page == 12) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('essay') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-copy" style="font-size: 15px"></i>
                            <span style="font-weight: 300">
                                Essay
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item @if($id_page == 13) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('draggable') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-map-signs" style="font-size: 15px"></i>
                            <span style="font-weight: 300">
                                Draggable
                            </span>
                        </a>
                    </li>

                    <p class="sidebar px-3 mt-3 mb-1" style="font-weight: 700; font-size: 13px">
                        Evaluation
                    </p>

                   
      
                    @endif

                    {{-- @if (auth()->user()->level == 'dosen')
                    <li class="sidebar-menu-item @if($id_page == 16) active @endif">
                        <a class="sidebar-menu-button" href="{{ route('class_recap') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-rocket" style="font-size: 15px"></i>
                            <span style="font-weight: 300">
                                Assessment Recap
                            </span>
                        </a>
                    </li>
                    @endif --}}

        
                    </ul>
                </div>
            </div>

            <div class="mt-auto sidebar-p-a sidebar-b-t d-flex flex-column flex-shrink-0">
                <a class="sidebar-link mb-2" href="{{ route('change_password') }}">
                    <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-lock" style="font-size: 15px"></i>
                    <span style="font-weight: 300">
                        Change Password
                    </span>
                </a>
                <a class="sidebar-link mb-2" href="/setting/edit_profil">
                    <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-edit" style="font-size: 15px"></i>
                    <span style="font-weight: 300">
                        Edit Profil
                    </span>
                </a>
            </div>

        </div>
    </div>
</div>