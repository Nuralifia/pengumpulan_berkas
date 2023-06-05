

					<!-- Simple login form -->
					<form action="" method="post">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><img src="assets/logo1.png" alt="Logo Surat Menyurat" width="100"></div>
								<h5 class="content-group">Silahkan Login Terlebih Dahulu </h5>
								<!-- <small class="display-block">Silahkan Masuk</small></h5> -->
								<?php
								echo $this->session->flashdata('msg');
								?>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control" name="username" placeholder="Masukkan Username" required>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="password" placeholder="Masukkan Katasandi" required>
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
									<div class="form-group">
										<button type="submit" name="btnlogin" class="btn btn-primary btn-block">Login </i></button>
									</div>
									<div class="form-group">
										<a href="welcome/index"><button type="button" class="btn btn-primary btn-block" class="cancelbtn" >Cancel </button></a>
									</div>
								</div>
							</div>


							<div class="text-center">
								<!-- <a href="web/lupa_password">Lupa Password??</a> -->
							</div>
						</div>
					</form>

            