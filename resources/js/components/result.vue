<template>
	<div class="p-3">			
		<div>
			<button class="btn btn-primary" @click="todup=false">show distinct</button>
			<button class="btn btn-danger" @click="todup=true">show duplicates</button>
		</div>
		<h2 class="text-secondary">Generate Result</h2>
		<button class="btn btn-primary" @click="aprint">Aspirant Votes Result</button>
		<button class="btn btn-info"  @click="vaprint">Voters Inputs</button>
		<div class="row p-3">			
			<div style="height: 55vh; overflow-y: scroll; border: 1px solid #ccc; border-radius: 5px;" class="col-md-6 p-3" >			
				<div v-for="aspirant in allaspirants" v-show="todup">
					<h6 class="text-warning">{{postName(aspirant)}}</h6>
					<table class="table table-bordered" v-if="postName(aspirant)">
						<thead>
							<th>Apirant </th>
							<th>Votes</th>
						</thead>
						<tbody>
							<tr v-for="asp in aspirant" >
								<td>{{asp.fname}} {{asp.lname}}</td>
								<td>{{asp.total}}</td>
							</tr>
						</tbody>
					</table>
				</div> 
				<div v-for="aspirant in allaspirantsX" v-show="!todup">
					<h6 class="text-warning">{{postName(aspirant)}}</h6>
					<table class="table table-bordered" v-if="postName(aspirant)">
						<thead>
							<th>Apirant </th>
							<th>Votes</th>
						</thead>
						<tbody>
							<tr v-for="asp in aspirant" >
								<td>{{asp.fname}} {{asp.lname}}</td>
								<td>{{asp.total}}</td>
							</tr>
						</tbody>
					</table>
				</div> 
			</div>
			<div style="height: 55vh; overflow-y: scroll; border: 1px solid #ccc; border-radius: 5px;" class="col-md-6">	
				<div  v-show="todup">										
					<table class="table table-bordered">
							<thead>
								<th >S/N</th>								
								<th>Voter ID</th>
								<th>Aspirant Name</th>
								<th>Aspirant Post</th>							
							</thead>
							<tbody>
								<tr v-for="(votes,index) in voters_inputs">
									<td>{{index+1}}</td>
									<td>{{votes.voter_id}}</td>
									<td>{{votes.fname}}  {{votes.lname}}</td>
									<td>{{votes.name}}</td>
								</tr>
							</tbody>
					</table>
					
				</div>
				<div v-show="!todup" class="bg-dark text-white">		
					<table class="table table-bordered" >
								<thead>
									<th class="text-white" >S/N</th>
									<th class="text-white" >Voter ID</th>
									<th class="text-white">Aspirant Name</th>
									<th class="text-white">Aspirant Post</th>							
								</thead>
								<tbody>
									<tr v-for="(votes, index) in voters_inputsX">										
										<td class="text-white">{{index+1}}</td>
										<td class="text-white">{{votes.voter_id}}</td>
										<td class="text-white">{{votes.fname}}  {{votes.lname}}</td>
										<td class="text-white">{{votes.name}}</td>
									</tr>
								</tbody>
						</table>								
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		data(){
			return {
				allaspirants:[],
				table:'',
				voters_inputs:[],
				voters_inputsX:[],
				mapResult:[],
				allaspirantsX:[],
				todup:true
			}
		},
		methods:{		
			postName(obj){
				if (obj.length != 0) {
					return obj[0].post_name;
				}
				//return false;
			},
			show_loader(){
                $('#system-loader').css({'display':'flex'});
            },
            hide_loader(){
                $('#system-loader').css('display','none');        
            },
            vaprint(){
            	
            	var votee="",voteA,votesX, touse,title="Result With duplicate";
            	if (this.todup){
            		touse =this.voters_inputs;
            	}else{
            		touse =this.voters_inputsX;
            		title="Result Without duplicate"

            	}
            	var table =`
            	<style>
            		table{width:100%;}
            		table, th, td {
					  border: 1px solid black;
					  border-collapse: collapse;
					}
					.text-warning{
						color:#f6993f;
					}
            		</style>
            	<h2 class="text-warning">${title}</h2>         
            	<table class="table table-bordered">
            					<thead>
								<th align="left">s/n</th>
								<th align="left">Voter ID</th>
								<th align="left">Aspirant Name</th>
								<th align="left">Aspirant Post</th>							
							</thead>
							<tbody>
							`;
					var ct=0;
            	for (var i = 0; i < touse.length; i++) {
            		voteA = touse[i];            		    				
            		ct++;
    				table += '<tr>';
    				table +='<td>'+ ct +'</td>';
    				table +='<td>'+voteA['voter_id'] +'</td>';
    				table +='<td>'+voteA['fname'] +' '+voteA['lname']+'</td>';
    				table +='<td>'+voteA['name']+'</td></tr>';    				
            	}
            	table+='</tbody></table>';
            	var printWin = window.open('','','width=1000');
					   printWin.document.write(table);
					   printWin.document.close();
					   printWin.focus();
					   printWin.print();
					   printWin.close();

			},
			 aprint(){
            	var table2 =`
            		<style>
            		table{width:100%;}
            		table, th, td {
					  border: 1px solid black;
					  border-collapse: collapse;
					}
					.text-warning{
						color:#f6993f;
					}
            		</style>
            	`;
            	var aspirantx="",aspx,votesX, touse,title="Result With duplicate";
            	if (this.todup){
            		touse =this.allaspirants;

            	}else{
            		touse =this.allaspirantsX;
            		title="Result Without duplicate"
            	}
            	for (var i = 0; i < touse.length; i++) {
            		aspirantx = touse[i];
            		table2 += '<h2 class="text-warning">'+title+'</h2>';
            		table2 += '<h2 class="text-warning">'+this.postName(aspirantx)+'</h2>';
            		 table2 +=`<table class="table table-bordered">
            					<tr>
								<th align="left" width="50%">Aspirant</th>
								<th align="left" width="50%">Vote Count</th>								
								</tr>
							<tbody> 
							`;
            		if (this.postName(aspirantx)){
            			for (var k = 0; k < aspirantx.length; k++) {
            				
            				aspx = aspirantx[k];
            				table2 += '<tr>';            				
            				table2 +='<td align="left">'+aspx.fname +' '+aspx['lname']+'</td>';
            				table2 +='<td align="left">'+aspx['total']+'</td><tr>';
            			}
            		}
            		table2+='</tbody></table>';
            	}
            	var printWin = window.open();
				   printWin.document.write(table2);
				   printWin.document.close();
				   printWin.focus();
				   printWin.print();
				   printWin.close();

			}


		},
		created(){
			this.show_loader();
			var $this = this;
            $.get("/voters_inputs", function(result){
            	$this.voters_inputs = result.duplicate;
            	$this.voters_inputsX = result.distinct;
            });
            $.get("/all_aspirants_vote", function(result){
                $this.allaspirants = result.duplicate;
                $this.allaspirantsX = result.distinct;
				$this.hide_loader();				
            });

		}
	}
</script>
<style scoped="">
	.footer{
		position: static !important;

	}
	td,th{
		font-size: 0.85em;
		padding: 4px;
	}

</style>