<?php
include ("koneksi/koneksi.php");
$item_per_page=5;
$page_per_block=3;
if (!isset($_GET['page']) ){
	$page  = 1;
	$block = 1;
	$offset = 0;
}
else{
   $page  = ($_GET['page']);
   $block = ceil($page/$page_per_block);
   $offset = $item_per_page * ($page-1);
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bioskop Online</title>
<script type="text/javascript" src="style/kutha.js"></script>
<link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body onload="autoPlay()">
<div id="header">
<div class="logo"></div>
<div class="nav">
	<ul class="navigasi">
            <li><a class="active" href="index.php" title="Home">Home</a></li>
            <li><a class="menu" href="#" title="Genre">Genre</a>
            	<ul>
                <?php
				$query = "select * from tb_kategori order by kategori asc";
				$hasil = mysql_query($query);
				while ($row = mysql_fetch_array($hasil))
				{
					echo '<li><a class="submenu" href="view/kategori.php?id='.$row['id'].'">'.$row['kategori'].'</a></li>';
				}
				?>
                </ul>
            </li>
            <li><a class="menu" href="#" title="Jadwal">Jadwal</a>
            	<ul>
                <li><a class="submenu" href="view/jadwal.php">Jadwal Tayang</a></li>
                <li><a class="submenu" href="view/rilis.php">Jadwal Rilis</a></li>
                </ul>
            </li>
            <li><a class="menu" href="view/daftarfilm.php" title="Daftar Film">Daftar Film</a></li>
            <?php
			if (isset($_SESSION['pengguna'])){
            echo '<li><a class="menu" href="controler/logout.php">Logout</a>
            </li>';
			}
			?>
	</ul>
</div>
</div>
<div id="main">
	<div class="banner">
    <img src="images/slide/1.png" width="880" height="300" border="0" alt="image" name="img" id="img" />
    </div>
	<div class="left">
        
        <?php
		function readmore($string){ $string = substr($string, 0, 200); $string = $string . "<br />"; return $string; }
		$query = "select * from tb_film order by id desc limit $offset, $item_per_page";
		$hasil = mysql_query($query);
		while ($row = mysql_fetch_array($hasil))
		{
            $deskrip = $row['deskripsi'];
			echo '<a href="view/detail.php?id='.$row['id'].'"><div class="content"><div class="tumb"><img src="'.$row['gambar'].'" alt="images" width="140" height="140" /></div>
            <div class="post"><b>'.$row['judul'].'</b><hr size="1" />
            '.readmore($deskrip).'
            </div></div></a>';
		}
		?>
        <div class="block">
		<center><?php 
		include ("controler/paging.php");
		$sql = "select * from tb_film order by id desc";
		paging($sql,$item_per_page, $page_per_block,'index.php', $page, $block);
		?></center>
        </div>
	</div>
    <div class="right">
    	<div class="conten-right">
            <div class="link">Search Film<hr size="1" />
            <form name="searchfilm" action="view/search.php" method="get">
            <input type="text" name="search" id="search" value="Cari" onfocus="searchFocus();" onblur="searchBlur();" style="font-style:italic;" /><br />
            <input type="submit" name="submit" value="Search" />
            </form>
            </div>
        </div>
        
        <div class="conten-right">
            <div class="link">New<hr size="1" />
            <ul>
            <?php
			$query = "select * from tb_film order by id desc limit 10";
			$hasil = mysql_query($query);
			while ($row = mysql_fetch_array($hasil))
			{
				echo '<li><a href="view/detail.php?id='.$row['id'].'">'.$row['judul'].'</a></li>';
			}
			?>
            </ul>
            </div>
        </div>
        <div class="conten-right">
        	<div class="link">Genre<hr size="1" />
            <ul>
            <?php
			$query = "select * from tb_kategori order by kategori asc";
			$hasil = mysql_query($query);
			while ($row = mysql_fetch_array($hasil))
			{
				echo '<li><a href="view/kategori.php?id='.$row['id'].'">'.$row['kategori'].'</a></li>';
			}
			?>
            </ul>
            </div>
        </div>
    </div>
    <div class="block"></div>
</div>
<div id="footer"><p>&copy;2014 Bioskop Online<br />Pesan Tiket Bioskop via Web &amp; Android<br />Design by <a href="admin/" target="_blank">Kutha Yoga</a></p></div>
</body>
</html>
<?php
mysql_close($kon);
?>