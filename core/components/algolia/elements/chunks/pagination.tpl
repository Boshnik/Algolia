<nav aria-label="Page navigation example">
	<ul class="pagination justify-content-center">
		<li class="page-item[[+page:is=`1`:then=` disabled`]]">
			<a class="page-link" href="[[+prev]]" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		[[+links]]
		<li class="page-item[[+page:eq=`[[+last]]`:then=` disabled`]]">
			<a class="page-link" href="[[+next]]" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
	</ul>
</nav>