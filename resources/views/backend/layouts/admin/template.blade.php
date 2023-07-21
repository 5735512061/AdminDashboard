<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no"/>
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Staff Edo Group</title>
		<meta name="author" content="codepixer">
		<meta name="description" content="">
		<meta name="keywords" content="">
		@include("/backend/layouts/css")
	</head>
	<body>
		<div class="layout-wrapper layout-content-navbar">
			<div class="layout-container">
				@include("backend/layouts/admin/navbar-left")
					<div class="layout-page">
						@include("backend/layouts/admin/navbar-top")
						<div class="content-wrapper">
							@yield("content")
							<div class="content-backdrop fade"></div>
						</div>
					</div>
				<div class="layout-overlay layout-menu-toggle"></div>
			</div>
		</div>
		@include("/backend/layouts/js")
	</body>
</html>