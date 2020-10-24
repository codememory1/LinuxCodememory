<div class="paginate">
	@for($i = 1; $i <= $handle['handle']->getOutputButton(); $i++)
		@if($handle['handle']->getActivePage() == $i)
			<a href="?page={{$i}}" class="active">{{$i}}</a>
		@else
			<a href="?page={{$i}}">{{$i}}</a>
		@endif
	@endfor
</div>

<style>
	.active {
		background: red;
		color: #fff;
		padding: 3px 5px;
		text-decoration: none;
		border-radius: 3px;
	}	
</style>
