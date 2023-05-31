<div class="dashboard_topNav"> 
    <a href="" id="logoutBtn" class="logoutBtn"><i class="fa fa-door-open logoutBtn"></i> Logout </a>
    <a href="" id="toggleBtn"><i class=""></i></a>

    <!-- database/logout.php -->
    <script>
    function script(){

        this.initialize = function(){
            this.registerEvents();
        },

        this.registerEvents = function(){
            document.addEventListener('click', function(e){
                targetElement = e.target;
                classList = targetElement.classList;


                if(classList.contains('logoutBtn')){
                   e.preventDefault();
                   BootstrapDialog.confirm({
                    type: BootstrapDialog.TYPE_DANGER,

                    message: 'Are you sure you want Logout?',
                    title: 'Logout User',
                    callback: function(isDelete){
                        if(isDelete){
                            $.ajax({
                            url: 'database/logout.php',
                            success: function(){
                                 location.reload();
                                }
                        });
                        }   
                    }
                   });
                }
            });
        }
    }

    var script = new script;
    script.initialize();
</script>
<?php include('partials/app-scripts.php'); ?>
<?php include('partials/app-header-scripts.php'); ?>
</div>