            <div class="row">
                <div class="mpHead">
	                <table>
		                <tr>		
		                    <form method="post" class="form-inline" action="uploadSongs">
		                        {{ csrf_field() }}
		                        <td class="col-xs-2 col-sm-8 col-md-8">			                   
			                        <input type="text" class="form-control" name="mpPath" id="mpPath" placeholder="Music Path">
			                    </td>
			                    <td class="col-xs-4 col-sm-4 col-md-4">    
			                        <button type="submit" class="btn btn-primary">Upload Songs</button>
			                    </td>    
		                	</form>
		                </tr>
		            </table>
               	</div>   
            </div>

            <hr>