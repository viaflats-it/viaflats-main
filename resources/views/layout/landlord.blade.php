<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landlord</title>
    <!-- css -->
{{ Html::style('css/custom.css') }}
{{ Html::style('css/app.css') }}

{{ Html::style('css/boostrap.min.css') }}
{{ Html::style('font-awesome-4.7.0/css/font-awesome.min.css') }}

<!-- js -->
    <script src="{{URL::asset('js/app.js')}}"></script>

    <script src="../node_modules/intl-tel-input/build/js/intlTelInput.js"></script>
    <script src="../node_modules/moment/min/moment.min.js"></script>

    {{--<link rel="stylesheet" href="../node_modules/intl-tel-input/build/css/intlTelInput.css">--}}

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

</head>

<body>
<!-- wrapper-->
<div class="wrapper">
    <!-- sidebar-->
    <div class="sidebar">
        <div class="sidebar-container">
            <div class="sidebar-header">
                <i id="menu" class="fa fa-bars" aria-hidden="true"></i>
                <i class="fa fa-home" aria-hidden="true"></i>
                <i class="fa fa-bell" aria-hidden="true"></i>
                <i class="fa fa-sign-out" aria-hidden="true"></i>
            </div>
            <ul class="sidebar-nav">
                <li><img class="image-profile" src="images/profiles/profilePic.svg" alt="img_profile"/></li>
                <li>
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <a href="profile_landlord">@lang('landlord.profile')</a>
                </li>
                <li>
                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                    <a href="add_property">@lang('landlord.add_property')</a>
                </li>
                <li>
                    <i class="fa fa-building" aria-hidden="true"></i>
                    <a href="my_properties">@lang('landlord.my_properties')</a>
                </li>
                <li>
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <a href="my_booking">@lang('landlord.my_booking')</a>
                </li>
                <li>
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    <a href="update_availabilities">@lang('landlord.update_availabilities')</a>
                </li>
                <li>
                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                    <a href="invoices">@lang('landlord.invoices')</a>
                </li>
                <li>
                    <i class="fa fa-envelope-open" aria-hidden="true"></i>
                    <a href="messages">@lang('landlord.messages')</a>
                </li>
                @if(Auth::user()->admin == 1)
                    <li class="admin">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <a href="addLandlord">@lang('landlord.adminAddlandlord')</a>
                    </li>
                @endif
                <li>
                    <i id="minimize" class="fa fa-arrow-left" aria-hidden="true"></i>
                </li>
            </ul>

        </div>
    </div>
    <!-- /sidebar-->

    <!--content -->
    <div class="content">
        <div class="content-container">
            @yield('content')
        </div>
    </div>
    <!--/content -->
</div>
<!-- /wrapper-->
<script type="text/javascript">
    let reverse = false;
    let menubool = true;

    /* safari comptability */

    $("#minimize").click(function () {
        let sidebar = $('.sidebar');
        let a = $('.sidebar-nav li a');
        let bell = $('.fa-bell');
        let home = $('.fa-home');
        let sign = $('.fa-sign-out');
        let sidebarNav = $('.sidebar-nav');
        let tl = new TimelineMax();
        let tl2 = new TimelineMax();
        let tl3 = new TimelineMax();

        if (!menubool) {
            tl2.to(home, 0.05, {
                opacity: 0,
                y: 0,
                ease: Power0.easeOut,
            }).to(bell, 0.05, {
                opacity: 0,
                y: 0,
                ease: Power0.easeOut,
            }).to(sign, 0.05, {
                opacity: 0,
                y: 0,
                ease: Power0.easeOut,
                onComplete: function () {
                    menubool = true;
                }
            }).to(sidebarNav, 0.3, {
                y: 0,
                ease: Power0.easeOut,
                onComplete: function () {

                    tl.to(a, 0.2, {
                        opacity: 0.35,
                        ease: Power0.easeOut,
                    }).to(a, 0.2, {
                        opacity: 1,
                        ease: Power0.easeOut,
                        onComplete: function () {
                            sidebar.toggleClass("sidebar-active");
                            a.css('position', 'relative');
                            reverse = false;
                            tl3.to(home, 0.1, {
                                opacity: 1,
                                x: 0,
                                ease: Power0.easeOut,
                            }).to(bell, 0.1, {
                                opacity: 1,
                                x: 0,
                                ease: Power0.easeOut,
                            }).to(sign, 0.1, {
                                opacity: 1,
                                x: 0,
                                ease: Power0.easeOut,
                            });
                        }
                    });
                }
            });
        } else {
            sidebar.toggleClass("sidebar-active");

            if (reverse) {
                tl3.to(home, 0.1, {
                    opacity: 1,
                    x: 0,
                    ease: Power0.easeOut,
                }).to(bell, 0.1, {
                    opacity: 1,
                    x: 0,
                    ease: Power0.easeOut,
                }).to(sign, 0.1, {
                    opacity: 1,
                    x: 0,
                    ease: Power0.easeOut,
                });

                tl.to(a, 0.2, {
                    opacity: 0.35,
                    ease: Power0.easeOut,
                    onComplete: function () {
                        a.css('position', 'relative');
                        reverse = false;
                    }
                }).to(a, 0.4, {
                    opacity: 1,
                    ease: Power0.easeOut,
                });
            } else {

                var windowHeight = $(window).height();
                if (windowHeight < 600) {
                    tl3.to(home, 0.1, {
                        opacity: 0,
                        x: 8,
                        ease: Power0.easeOut,
                    }).to(bell, 0.1, {
                        opacity: 0,
                        x: -17,
                        ease: Power0.easeOut,
                    }).to(sign, 0.1, {
                        opacity: 0,
                        x: -41,
                        ease: Power0.easeOut,
                    });
                } else {
                    tl3.to(home, 0.1, {
                        opacity: 0,
                        x: 10,
                        ease: Power0.easeOut,
                    }).to(bell, 0.1, {
                        opacity: 0,
                        x: -19,
                        ease: Power0.easeOut,
                    }).to(sign, 0.1, {
                        opacity: 0,
                        x: -47,
                        ease: Power0.easeOut,
                    });
                }

                tl.to(a, 0.4, {
                    opacity: 0,
                    ease: Power0.easeOut,
                }).to(a, 0.2, {
                    opacity: 0,
                    ease: Power0.easeOut,
                    onComplete: function () {
                        a.css('position', 'absolute');
                        reverse = true;
                    }
                });
            }
        }
    });

    $('#menu').click(function () {

        let bell = $('.fa-bell');
        let home = $('.fa-home');
        let sign = $('.fa-sign-out');
        let sidebar = $('.sidebar-nav');
        let tl = new TimelineMax();

        if (menubool) {
            tl.to(sidebar, 0.3, {
                y: 65,
                ease: Power0.easeOut,
            }).to(home, 0.05, {
                opacity: 1,
                y: 25,
                ease: Power0.easeOut,
            }).to(bell, 0.05, {
                opacity: 1,
                y: 47,
                ease: Power0.easeOut,
            }).to(sign, 0.05, {
                opacity: 1,
                y: 69,
                ease: Power0.easeOut,
                onComplete: function () {
                    menubool = false;
                }
            });
        } else {
            tl.to(home, 0.05, {
                opacity: 0,
                y: 0,
                ease: Power0.easeOut,
                onComplete: function () {
                }
            }).to(bell, 0.05, {
                opacity: 0,
                y: 0,
                ease: Power0.easeOut,
                onComplete: function () {
                }
            }).to(sign, 0.05, {
                opacity: 0,
                y: 0,
                ease: Power0.easeOut,
                onComplete: function () {
                    menubool = true;
                }
            }).to(sidebar, 0.3, {
                y: 0,
                ease: Power0.easeOut,
            });
        }
    });
</script>
</body>
</html>
