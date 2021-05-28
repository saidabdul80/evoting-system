<template>
	<div>		
		<div>
			<button class="btn btn-primary" @click="todup=false">show distinct</button>
			<button class="btn btn-danger" @click="todup=true">show duplicates</button>
		</div>
		<div class="gridScale" v-show="todup">
			<div v-for="(post,index) in allaspirants"  >			
				<ul class="scroller " v-for="aspirant in post" >
					<li class="position-relative " data-aos="fade-left"
					     data-aos-anchor="#example-anchor"
					     :data-aos-offset="index*200"
					     :data-aos-duration="index*200" >
						<div class="position-absolute">
							<div class="mt-3">{{aspirant.total}}</div>
							<span class="mini-pos">{{aspirant.post_abbr}}</span>
						</div>
						<img :src="aspirant.image" width="100%">
						<span class="text-upper">{{aspirant.fname}} {{aspirant.lname}}</span>
					</li>
				</ul>
			</div>
		</div>
		<div class="gridScale bg-dark" v-show="!todup">
			<div v-for="(post,index) in allaspirantsX"  >			
				<ul class="scroller " v-for="aspirant in post" >
					<li class="position-relative " data-aos="fade-left"
					     data-aos-anchor="#example-anchor"
					     :data-aos-offset="index*200"
					     :data-aos-duration="index*200" >
						<div class="position-absolute">
							<div class="mt-3">{{aspirant.total}}</div>
							<span class="mini-pos">{{aspirant.post_abbr}}</span>
						</div>
						<img :src="aspirant.image" width="100%">
						<span class="text-upper">{{aspirant.fname}} {{aspirant.lname}}</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>
<script >
	export default{
		data(){
			return {
				allaspirants:[],
				allaspirantsX:[],
				todup: true,
			}
		},
		methods:{		
			show_loader(){
                $('#system-loader').css({'display':'flex'});
            },
            hide_loader(){
                $('#system-loader').css('display','none');        
            },
            forGrid(resultx){
            	var rcount = resultx.length;
                if (rcount < 5) {

	                $('.gridScale').css(
	                	'grid-template-columns', 'repeat(auto-fit, minmax(100px, 1fr))'
	                );					
                }
            }

		},
		created(){
			this.show_loader();
			var $this = this;
            $.get("/all_aspirants_vote", function(result){
                $this.allaspirants = result.duplicate;
		        $this.allaspirantsX = result.distinct;	

				$this.hide_loader();
				$this.forGrid(result);
            });

		},
		mounted(){
			var $this = this;
			$(document).ready(function(){
				setInterval(function(){
					$.get("/all_aspirants_vote", function(result){
		                $this.allaspirants = result.duplicate;	
		                $this.allaspirantsX = result.distinct;	
		                var rcount = result.length;
		               	$this.forGrid(result);
		            });					
				},5000);	
				setTimeout(function() {
					AOS.init();		
				}, 2000);	
				(function($) {
            		$(function() { //on DOM ready
		                $(".scroller").simplyScroll({
		                    customClass: 'vert',
		                    orientation: 'vertical',
		                    auto: true,
		                    manualMode: 'end',
		                    frameRate: 24,
		                    speed: 1
		                });
		            });
		        })(jQuery);

			});
		},
		props:[

		]
	}
</script>
<style scoped="">
	* {
  box-sizing: border-box;
}
.simply-scroll {
	width: 400px;
    height: 1000px;
    margin-bottom: 1em;
 }
.vert .simply-scroll-clip {
    width: 400px;
}
.vert .simply-scroll-list li {
    width: auto;
    height: auto;
}
	.cardl{        
        box-shadow: 0px 1px 3px #ccc;
        border-radius: 5px;
        height: 75vh;
        overflow:scroll;
    }
    .mcard{
        height: 260px; width:200px;padding: 0px;float: left;margin:10px;
    }
    .mimg{
        height: 200px;width: 100%; box-shadow: 1px -1px 8px #ccc; border-radius: 7px 7px 0px 0px;        
    }
    .mbtn{
        width: 100%;height: 60px;
    }	

    .position-relative{
    	position:relative;
    	height: 150px;
    }
    .position-absolute{
    	position: absolute;
    	bottom: 0px;
    	left: 0%;
    	width: 100%;
    	font-size: 1.7em;
    	font-weight: bolder;
    	text-align: center;
        box-shadow: 0px 1px 3px #ccc;
        border-radius: 0px 0px 5px 5px;    	 
        background: white;
        height: 40%;
    }
    img{
        border-radius: 0px 0px 5px 5px;  
        height: 150px;  	     	
    }
   /* .position-absolute:after{
    	content:'Votes Count:';
    	display: block;
    	position: absolute;
    	top: 2px;    	
    	font-size: 0.3em;
    	color:var(--warning);
    	width: 100%;
    	text-align: left;
    	white-space: nowrap;    
    	padding-left: 4px;
    	z-index: 1000;
    }*/
    .mini-pos{    	
    	display: block;
    	position: absolute;
    	top: 2px;    	
    	font-size: 0.4em;
    	color:var(--warning);
    	width: 100%;
    	text-align: right;
    	z-index: 1000;
    	padding-right: 5px;
    }
    ul{
    	padding: 0px 5px;

    }
    ul li{
    	list-style: none;
    	display: flex;
    	flex-direction: column;
    }
    .gridScale{
    	padding: 10px 20px;
    	display: grid;    	
    	margin: 0 auto;
    	grid-gap: 2px;    	
  		grid-template-columns:repeat(auto-fit, minmax(100px, 1fr));
    }
    .text-upper{
    	text-transform: uppercase;
    	position: absolute;
    	color: white;
    	font-weight: bolder;
    	top: 42%;
    	display: block;
    	padding: 2px;
    	background: rgba(255,255,255,.5);
    	width: 100%;
    	overflow-x: scroll;
    	white-space: nowrap;
    	text-shadow: 1px 1px 4px #555;
    }
    /* width */
::-webkit-scrollbar {
  width: 0px;
}

/* Track */
::-webkit-scrollbar-track {  
  border-radius: 10px;
  width: 0px;
  height: 0px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: transparent; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}
</style>
