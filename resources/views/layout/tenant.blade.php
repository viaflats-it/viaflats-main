<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tenant</title>
  <!-- css -->
  {{ Html::style('css/app.css') }}
  <!-- js -->
  <script src="{{URL::asset('js/app.js')}}"></script>
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
              <li><img class="image-profile" src="images/profiles/profilePic.svg" alt="img_profile" /></li>
              <li>
                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                  <a href="tenant">@lang('tenant.profile')</a>
              </li>
              <li>
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                  <a href="my_reservation">@lang('tenant.my_reservation')</a>
              </li>
              <li>
                  <i class="fa fa-folder-open" aria-hidden="true"></i>
                  <a href="invoices">@lang('tenant.invoices')</a>
              </li>
              <li>
                  <i class="fa fa-envelope-open" aria-hidden="true"></i>
                  <a href="messages">@lang('tenant.messages')</a>
              </li>
              <li>
                  <i class="fa fa-cog" aria-hidden="true"></i>
                  <a href="account">@lang('tenant.settings')</a>
              </li>
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
          @yield('contenu')
      </div>
  </div>
  <!--/content -->
</div>
<!-- /wrapper-->
<script type="text/javascript">
  let reverse = false;
  let menubool = true;

  /* safari comptability */

  $("#minimize").click(function() {
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
        onComplete: function() {
          menubool = true;
        }
      }).to(sidebarNav, 0.3, {
        y: 0,
        ease: Power0.easeOut,
        onComplete: function() {

          tl.to(a, 0.2, {
            opacity: 0.35,
            ease: Power0.easeOut,
          }).to(a, 0.2, {
            opacity: 1,
            ease: Power0.easeOut,
            onComplete: function() {
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
          onComplete: function() {
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
          onComplete: function() {
            a.css('position', 'absolute');
            reverse = true;
          }
        });
      }
    }
  });

  $('#menu').click(function() {

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
        onComplete: function() {
          menubool = false;
        }
      });
    } else {
      tl.to(home, 0.05, {
        opacity: 0,
        y: 0,
        ease: Power0.easeOut,
        onComplete: function() {}
      }).to(bell, 0.05, {
        opacity: 0,
        y: 0,
        ease: Power0.easeOut,
        onComplete: function() {}
      }).to(sign, 0.05, {
        opacity: 0,
        y: 0,
        ease: Power0.easeOut,
        onComplete: function() {
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
