<?php /* phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript, Internal.NoCodeFound */ ?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<style type="text/css">
	.mantle-card {
		background: white;
		border-radius: 10px;
		box-shadow: inset 0px 0px 0px 1px rgba(26, 26, 0, 0.16);
		display: block;
		padding: 20px;
		transition: background-color 0.2s ease-in-out;
		text-decoration: none !important;
	}

	a.mantle-card:hover {
		background-color: rgba(0, 0, 0, 0.05);
	}
</style>
<div class="w-full px-5 md:px-0 md:max-w-1/2 lg:max-w-3/4 mx-auto my-20">
	<div class="p-5 pb-8 text-center space-y-5">
		<img
			src="https://mantle.alley.com/img/logo-no-text.svg"
			alt="Mantle"
			class="max-w-1/2 lg:max-w-[200px] mx-auto"
		/>
		<h2 class="!text-5xl !font-bold">Mantle by Alley</h2>
		<p class="text-center !text-2xl text-gray-600 lg:max-w-2/3 mx-auto">Mantle is a framework for building large, robust websites and applications with WordPress</p>
	</div>
	<div class="grid lg:grid-cols-3 gap-5 text-left">
		<a
			href="https://mantle.alley.com/?ref=welcome"
			target="_blank"
			class="lg:col-span-2 mantle-card"
		>
			<img src="https://mantle.alley.com/img/website.png" alt="Mantle" class="w-full mb-3" />
			<h4 class="!text-xl !font-bold">Documentation</h4>
			<p class="text-gray-600 !text-lg">Learn how to use Mantle to build your next project by reading the documentation.</p>
		</a>
		<div class="lg:col-span-1 space-y-5">
			<a
				href="https://github.com/alleyinteractive/mantle-framework"
				target="_blank"
				class="mantle-card">
				<h4 class="!text-xl !font-bold">GitHub</h4>
				<p class="text-gray-600 !text-lg">View the source code and contribute to the project on GitHub.</p>
			</a>
			<a
				href="https://alley.com/?ref=mantle"
				target="_blank"
				class="mantle-card"
			>
				<h4 class="!text-xl !font-bold">Alley</h4>
				<p class="text-gray-600 !text-lg">Learn more about Alley and how we can help you build your next project.</p>
			</a>
		</div>
	</div>
</div>
