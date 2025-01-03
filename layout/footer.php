


            </div>
            </main>
            <?php include 'components/footer.php';?>

            
            
            </div>
        </div>
        <?php include 'pages/login/login.php'; ?>
    
        <script src="assets/js/app.js"></script>
          
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="assets/plugins/dataTables/dataTables.min.js"></script>
        <!-- <script src="assets/plugins/select2/select2.min.js"></script> -->


        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/locale/id.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>


        <script src="helper/helper.js"></script>
       
        
        <script>
            var loginRoleId = '<?php echo $_SESSION['user']['role']; ?>';
            $(() => {
                if(loginRoleId == 4) {
                    checkDeadline('<?php echo $_SESSION['user']['id']; ?>');
                }
                getNotificationByUser();
            })

            closeBtn = () => {
                $('.alert-space').fadeOut(800, function() {
                    $(this).html('');
                });
            }

            formatDate = (dateString) => {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false // Gunakan format 24 jam
                };
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', options); // Format untuk Indonesia
            };

            readNotif = (id) => {
                $.ajax({
                    url: '/tataTertib/system/notification.php',
                    data : {
                        action : 'readNotification',
                        id : id
                    }, 
                    type: 'POST',
                    success: (data) => {
                        
                    }
                })
            }

            checkDeadline = (id) => {
                $.ajax({
                    url: '/tataTertib/system/notification.php',
                    data : {
                        action : 'checkDeadline',
                        id : id
                    }, 
                    type: 'POST',
                    success: (res) => {
                        res = JSON.parse(res);
                        if(res.alert){
                            console.log("ada")
                            
                            var html = $(`
                                <div class="alert alert-${res.alert.color} d-flex align-items-center">
                                    <span class="fs-1 fa fa-${res.alert.icon}"></span>
                                    <span class="fs-3 alert-message">${res.alert.message}</span>
                                    <a onclick="closeBtn()" style="text-decoration: none; color: #a94442" class=" fs-3 alert-close-btn" id="closeBtn">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>`);
                            $('.alert-space').html(html);
                        }
                    }
                })
            }

            getNotificationByUser = () => {
                $.ajax({
                    url: '/tataTertib/system/notification.php',
                    data : {
                        action : 'getNotificationByUser'
                    }, 
                    type: 'POST',
                    success: (data) => {
                        data = JSON.parse(data);
                        var html = ``;
                        $('.notif_count').html(data.num_rows);
                        
                        if(data.num_rows == 0) {
                            $('.notif_count').addClass('d-none');
                        }else{
                            $('.notif_count').removeClass('d-none');
                        }
                        $.each(data.data, (i, v) => {
                            html += `
                                <a href="${v.direct_link}" onclick="readNotif(${v.id})" class="list-group-item">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-12">
                                            <div class="small mt-1">${v.content}</div>
                                            <div class="text-muted small mt-1">${v.created_at ? formatDate(v.created_at.date) : '-'}</div>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });

                        $('.list-notification').html(html);
                    }
                })
            }
        </script>
    </body>
    
    </html>