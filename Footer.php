<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<h1><?php echo $row['Hospital_Name']; ?></h1>
									</div>
										<div class="social-icon">
											<ul>
												<li>
													<a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i> </a>
												</li>
												<li>
													<a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
												</li>
												<li>
													<a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i> </a>
												</li>
												<li>
													<a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
												</li>
											</ul>

									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Admin</h2>
									<ul>
										<li><a href="Admin/login.php" target="_blank"><i class="fas fa-angle-double-right"></i> Login</a></li>
									</ul>

								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Doctors</h2>
									<ul>
										<li><a href="doctor-login.php"><i class="fas fa-angle-double-right"></i> Login</a></li>
										<li><a href="doctor-register.php" ><i class="fas fa-angle-double-right"></i> Register</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p><?php echo $row['Address'];?>, <?php echo $row['City'];?>,<br> <?php echo $row['State'];?>, <?php echo $row['Country']." - ".$row['ZipCode'];?> </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											<?php echo $row['Hospital_Mobile']; ?>
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											<?php echo $row['Hospital_Email']; ?>
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p><a href="index.php"><?php echo $row['Hospital_Copyright']; ?></a></p>
									</div>
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->