<template>
    <div class="container-fluid">
        <div class="row" v-if="!loading">
            <div class="col-md-3 col-sm-12 p-0" style="height: 78vh; overflow-y: scroll;">
                <ul class="p-0 leftBar">
                    <li v-for="post in aspirants" v-show="post.aspirants.length >0" @click="LoadAspirant(post,$event)">
                        <div>{{post.name}}</div> <i class="fa fa-chevron-right"></i>
                    </li>
                    <li @click="Submit">
                        <span>Submit</span><span class="fa fa-chevron-right text-secondary"></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12 p-0 px-2 position-relative" v-if="!reloader">
                <div class="card-title" v-if="positionClicked !='' ">{{positionClicked}}</div>
              <div class="cardl p-3">
                    <div class="w-100 d-flexi covergeneral">
                        <span>
                            <br>
                            <h3 class="text-secondary text-center" data-aos="fade-left"                     
                     :data-aos-offset="200"
                     :data-aos-duration="200">Select Position of Your Aspirant and Click Vote One After the other. </h3>
                            <br><br>
                            <h4 class="text-secondary text-center text-warning">Then Click Submit to Process Your Votes</h4>                            
                        </span>
                        <img src="/Vote.png" style="position: relative;right: 0;width: 50%;">
                    </div>

                <div v-for="post in aspirants" :id="'cover_'+genClass(post.abbr)" class="covergeneral d-nonei">
                    <center>
                        <div v-for="aspirant in post.aspirants" :class="genClass(post.abbr)+' mcard'">
                            <img :src="aspirant.image" class="mimg">
                            <div class="bg-info mbtn"  >
                                <h5 class="text-center text-white text-upper">{{aspirant.fname+'  '+aspirant.lname}}</h5>
                                <button class="shadow-lg bg-white py-2 px-4 btn btn-white " @click="selectCandidate(genClass(post.abbr),aspirant.id, $event.target)">Vote</button>
                            </div>
                        </div>
                    </center>
                </div>
              </div>
            </div>
        </div> 
    </div>
</template>

<script>
    export default {
        data(){
          return {
            posts:[],
            aspirants:[],
            selectedAspirants:[],
            userIdentity:'',
            checktovote:true,
            loading:true,
            positionClicked:'',
            reloader:false,
            }
        },
        methods:{
            createFormData: function(data){             
                const formData = new FormData();
                Object.keys(data).forEach(key => formData.append(key, data[key]));
                return formData;
            },
            genClass(name){
                var name1 = name.split(' ');
                return name1[0].replace('.','');
            },
            LoadAspirant(obj,e){
                e = e.currentTarget;
                this.positionClicked = obj.name;
              
                $('.covergeneral').hide();
                $('#cover_'+this.genClass(obj.abbr)).css({'display':'block'});   
                $('.leftBar').find('li').removeClass('bg-selected');
                $(e).addClass('bg-selected');
            },
            reelecting(id){
                var $this =this;
                   $('.reElect').on('click', function(){
                    var $thisObj = $(this);
                    Swal.fire({
                        title: 'Do you want to Re-Elect',
                        confirmButtonText:'Yes',                                                 
                        cancelButtonText:'No',                                                 
                        confirmButtonColor:'#00b96b',  
                        cancelButtonColor:'#b9006b',                          
                    }).then((result)=>{
                        if (result.isConfirmed){
                            $('.'+$(this).attr('rel')).show();
                            $('.'+$(this).attr('rel')).find('button').text('Vote');
                            $('.'+$(this).attr('rel')).find('button').addClass('bg-white btn-white');                
                            $('.'+$(this).attr('rel')).find('button').css('color','#222');        
                            var index = '';        
                           $this.selectedAspirants.find((item,i)=>{ if(item == $(this).attr('data-id')){ index =i;} })
                            if (index!== '') {
                                $this.selectedAspirants.splice(index,1);
                            }
                            $thisObj.remove();
                        }
                    })
                });
               },
            show_loader(){
                $('#system-loader').css({'display':'flex'});
            },
            hide_loader(){
                $('#system-loader').css('display','none');        
            },
            selectCandidate(cl,id,e){                

                $(e).parent().parent().attr({'data-aos':"fade-down-right","data-aos":"fade-left","data-aos-anchor":"#example-anchor","data-aos-offset":"500","data-aos-duration":"500"});
                 AOS.init();                                         
                $('.'+cl).not($(e).parent().parent()).hide(200);                
                $(e).text('Selected');
                $(e).removeClass('bg-white btn-white');                
                $(e).css({'background':'#2c6', 'color':'white'});
                $(e).css('color','white');
                if (!this.selectedAspirants.includes(id)) {
                    this.selectedAspirants.push(id)             
                }
                $(e).after('<div rel="'+cl+'" data-id="'+id+'" style="position:absolute;bottom:30px; width:200px;padding:5px 30px;" class="btn btn-danger reElect">Re-Elect</div>');
                this.reelecting();
            },
            toVoteLoader(){
                var $this = this, countx =0;
                var tov = setInterval(function(){
                    if ($this.userIdentity=='') {
                        if (countx ==0) {
                           // $this.toVote();
                            countx =1;
                        }
                    }else{
                        clearInterval(tov);
                    }
                },1000);
            },
            toVote(){
                var $this = this;
                Swal.fire({
                      title: 'Please Identify Yourself',                          
                      html: `<input id="swal-input2" type="text" class="form-control">`,
                      confirmButtonText:'Continue',                                                 
                      confirmButtonColor:'#00b96b',                       
                      showCancelButton:false,  
                      icon: 'warning',                        
                      showLoaderOnConfirm: true,
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                     closeOnClickOutside:false,
                       preConfirm: (login) => {    
                        var uid = $('#swal-input2').val();
                          const formData = new FormData();
                            formData.append('user_id',uid);
                            formData.append('_token',this.csrf);
                        return  $.ajax({
                            url: "/check_eligibility", 
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                 if(result.code==419){
                                    Swal.showValidationMessage(
                                      `Failed: Sorry You Are Not Eligible To Vote`
                                    )                                   
                                }else if(result.code == 409){
                                    Swal.showValidationMessage(
                                      `Failed: Sorry You Can't Vote Twice`
                                    )                 
                                }else{
                                    $this.userIdentity = uid;
                                    $this.reloader = true
                                    $this.selectedAspirants = [];
                                    setTimeout(function() {
                                        $this.reloader= false
                                    }, 50);
                                }
                                return[
                                    true,
                                ];
                            },
                            error:function(err){
                                console.log(err.response);
                                alert('please retry, or contact the administrator');
                                $this.Submit();
                            }
                        })
                      },
                   
                    })
                
            },
            resubmitmsg(){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 10000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })

                  Toast.fire({
                    icon: 'error',
                    title: 'Please resubmit',
                    text: 'something went wrong'
                  })
            },
            submitmsg(){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })

                  Toast.fire({
                    icon: 'success',
                    title: 'Successfully Voted'
                  })
            },
            Submit(){
                var $this = this;
                if(this.selectedAspirants.length ==0){
                    Swal.fire({
                      title: 'You Have Not Voted for any Candidate',
                      icon:'warning',                                                
                      confirmButtonText:'Ok',                                                 
                      confirmButtonColor:'#00b96b',                       
                  })
                    return false;
                }
                if (this.userIdentity == '') {
                      Swal.fire({
                      title: 'Please Identify Yourself',                          
                      html: `<input id="swal-input2" type="text" class="swal-input form-control">`,
                      confirmButtonText:'Continue',                                                 
                      confirmButtonColor:'#00b96b',                       
                      showCancelButton:false,  
                      icon: 'warning',                        
                      showLoaderOnConfirm: true,
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                     closeOnClickOutside:false,
                       preConfirm: (login) => {    
                            var uid = $('#swal-input2').val();                            
                            const formData = new FormData();
                            formData.append('user_id',uid);
                            formData.append('_token',this.csrf);
                        return  $.ajax({
                            url: "/check_eligibility", 
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                 if(result.code==419){
                                    Swal.showValidationMessage(
                                      `Failed: Sorry You Are Not Eligible To Vote`
                                    )                                   
                                }else if(result.code == 409){
                                    Swal.showValidationMessage(
                                      `Failed: Sorry You Can't Vote Twice`
                                    )                 
                                }else{
                                    const formData = new FormData();
                                    formData.append('user_id',uid);
                                    formData.append('_token',this.csrf);
                                    formData.append('selected_candidate',JSON.stringify($this.selectedAspirants));
                                    $.ajax({
                                        url: "/submit_elect", 
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(result) {
                                            if (result.code ==200){
                                                $this.submitmsg();
                                                 setTimeout(function() {
                                                    $this.toVote();
                                                }, 3500);
                                            }else{
                                                $this.resubmitmsg();
                                            }

                                        }, error:function(err){
                                            console.log(err);
                                            alert('please retry, or contact the administrator');
                                            $this.Submit();
                                        }                                  
                                    });
                                }
                            },
                            error:function(err){
                                console.log(err.response);
                                alert('please retry, or contact the administrator');
                                $this.Submit();
                            }
                        })
                        return [ true];               
                      },
                   
                    })
                }else{
                    const formData = new FormData();
                    formData.append('user_id',$this.userIdentity);
                    formData.append('_token',this.csrf);
                    formData.append('selected_candidate',JSON.stringify($this.selectedAspirants));
                    $.ajax({
                        url: "/submit_elect", 
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            if (result.code ==200){
                                $this.userIdentity = '';
                                $this.submitmsg();
                                setTimeout(function() {
                                    $this.toVote();
                                }, 3500);
                            }else{
                                $this.resubmitmsg();
                            }

                        }, error:function(err){
                            console.log(err);
                            alert('please retry, or contact the administrator');
                            $this.Submit();
                        }                                  
                    });
                }
            }
        },
        created(){
            var $this = this;
            this.show_loader();
            $.post("/get_posts", {_token:this.csrf}, function(result){
                $this.posts = result;
            });
            $.post("/get_aspirants", {_token:this.csrf}, function(result){
                $this.aspirants = result;
                $this.hide_loader();
                $this.loading = false
            });
            this.toVoteLoader();
            
        },
        props:['csrf'],
        mounted() {
            console.log('Component mounted.')

            $(document).ready(function(){
                AOS.init(); 

            });
        }
    }
</script>

<style>
    :root {
  --animate-delay: 2s;
    --animate-duration: 2s;
}

    .leftBar li{
        list-style: none;
        padding: 9px 14px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        color: var(--secondary);
        user-select: none;
    }
    .leftBar{
        border-right: 1px solid #eee;
        border-top: 10px solid var(--warning);

    }
    .leftBar li span{
        transition: 0.4s all;

    }
    .leftBar li{
        border-bottom: 1px solid #eee;
    }
    .leftBar li:hover{
        color: var(--warning);
    }
    .leftBar li:hover span:last-child{
        color: var(--warning) !important;
    }
    .leftBar li:active span:first-child{
        margin-left: 10px;

    }
    .cardl{
        border-top: 10px solid var(--info);
        box-shadow: 0px 1px 3px #ccc;
        border-radius: 5px;
        height: 75vh;
        overflow:scroll;
    }
    .mcard{
        height: 260px; width:200px;padding: 0px;float: left;margin:10px;
    }
    .mimg{
        height: 200px;
        width: 100%;
        box-shadow: 1px -1px 8px #ccc; border-radius: 7px 7px 0px 0px;        
    }
    .mbtn{
        width: 100%;height: 60px;
    }
    .text-upper{
        text-transform: uppercase;
        overflow:hidden;
    }
    .position-relative{
        position: relative;
    }
    .card-title{
        padding: 6px 10px;
        width: 240px;
        position: absolute;
        left: 37%;
        top: -10px;
        border-radius: 5px;
        background: var(--info);
        color:white;
        font-weight: bolder;
        text-align: center;
    }
    .d-flexi{
        display: flex;
    }
    .d-nonei{
        display: none;
    }
    .bg-selected{
        background:var(--warning);
        color:white !important;
    }
</style>
