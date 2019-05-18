<?php
	namespace BeltranPhotoStock\Model;
	
	require_once('model/Client.php');
	require_once('model/Photographer.php');
	
	use \BeltranPhotoStock\Model\DBConnector;
	require_once('model/DBConnector.php');
	use \BeltranPhotoStock\Exception\NotFoundDBException;
	require_once('exceptions/NotFoundDBException.php');
	
	class DAO extends DBConnector {
		
		public function getClientById($id) {
			return $this->getUserById('client', $id);
		}
		
		public function getPhotographerById($id) {
			return $this->getUserById('photographer', $id);
		}
		
		public function getAdminById($id) {
			return $this->getUserById('admin', $id);
		}
		
		private function getUserById($userType, $id) {
			switch($userType) {
				case 'client':
					$sql = 'SELECT id_client, civilite, nom, prenom, dateNaissance,
						adresse, cp, ville, pays, telephone, email, hashIdentifiants,
						disponible FROM client WHERE id_client = ? ;';
					break;
				case 'photographer':
					$sql = 'SELECT id_photographe, civilite, numSiret, ribIBAN, nom,
						prenom, societe, adresse, cp, ville, pays, telephone, email,
						hashIdentifiants, disponible FROM photographe WHERE id_photographe = ? ;';
					break;
				case 'admin':
					$sql = 'SELECT id_admin, civilite, nom, prenom, dateNaissance,
						adresse, cp, ville, pays, telephone, email, hashIdentifiants,
						disponible FROM administrateur WHERE id_admin = ? ;';
					break;
			}
			$pdoLink = $this->db->prepare($sql);
			$pdoLink->execute(array($id));
			$userData = $pdoLink->fetchAll();
			if(count($userData) == 0) {
				throw new NotFoundDBException('User ID not found in database');
			}
			switch($userType) {
				case 'client':
					return new Client($userData[0]);
				case 'photographer':
					return new Photographer($userData[0]);
				case 'admin':
					return new Admin($userData[0]);
					break;
			}
		}
		
		/**
		 * Insert a new client into the database
		 * @param  Client $client User to add into the database
		 * @return int            Primary key of the new row
		 */
		public function addClient($client) {
			$c = $client->getData();
			$c = array(
				$c['civilite'],
				$c['nom'],
				$c['prenom'],
				$c['dateNaissance'],
				$c['adresse'],
				$c['cp'],
				$c['ville'],
				$c['pays'],
				$c['telephone'],
				$c['email'],
				$c['hashIdentifiants'],
				$c['disponible']
			);
			try {
				$sql = 'INSERT INTO client(civilite, nom, prenom, dateNaissance,
					adresse, cp, ville, pays, telephone, email, hashIdentifiants, disponible)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
				$pdoLink = $this->db->prepare($sql);
				$pdoLink->execute($c);
			} catch(PDOException $e) {
				print_r($e->getMessage());
				die();
			}
			return $this->db->query('SELECT LAST_INSERT_ID();')->fetch()[0];
		}
		
		/**
		 * Insert a new photographer into the database
		 * @param  Photographer $pgrpher User to add into the database
		 * @return int                   Primary key of the new row
		 */
		public function addPhotographer($pgrpher) {
			$p = $pgrpher->getData();
			$p = array(
				$p['civilite'],
				$p['numSiret'],
				$p['ribIBAN'],
				$p['nom'],
				$p['prenom'],
				$p['societe'],
				$p['adresse'],
				$p['cp'],
				$p['ville'],
				$p['pays'],
				$p['telephone'],
				$p['email'],
				$p['hashIdentifiants'],
				$p['disponible']
			);
			try {
				$sql = 'INSERT INTO photographe(civilite, numSiret, ribIBAN, nom,
					prenom, societe, adresse, cp, ville, pays, telephone, email,
					hashIdentifiants, disponible) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
				$pdoLink = $this->db->prepare($sql);
				$pdoLink->execute($p);
			} catch(PDOException $e) {
				print_r($e-getMessage());
				die();
			}
			return $this->db->query('SELECT LAST_INSERT_ID();')->fetch()[0];
		}
		
		/**
		 * Insert a new admin into the database
		 * @param  Admin $admin User to add into the database
		 * @return int          Primary key of the new row
		 */
		public function addAdmin($admin) {
			$a = $admin->getData();
			$a = array(
				$a['civilite'],
				$a['nom'],
				$a['prenom'],
				$a['dateNaissance'],
				$a['adresse'],
				$a['cp'],
				$a['ville'],
				$a['pays'],
				$a['telephone'],
				$a['email'],
				$a['hashIdentifiants'],
				$a['disponible']);
			try {
				$sql = 'INSERT INTO administrateur(civilite, nom, prenom, dateNaissance,
					adresse, cp, ville, pays, telephone, email, hashIdentifiants, disponible)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
				$pdoLink = $this->db->prepare($sql);
				$pdoLink->execute($a);
			} catch(PDOException $e) {
				print_r($e-getMessage());
				die();
			}
			return $this->db->query('SELECT LAST_INSERT_ID();')->fetch()[0];
		}
		
		public function delClient($id) {
			$sql = 'DELETE FROM client WHERE id_client = ?;';
			$pdoLink = $this->db->prepare($sql);
			$pdoLink->execute(array($id));
		}
		
		public function delPhotographer($id) {
			$sql = 'DELETE FROM photographe WHERE id_photographe = ?;';
			$pdoLink = $this->db->prepare($sql);
			$pdoLink->execute(array($id));
		}
		
		public function delAdmin($id) {
			$sql = 'DELETE FROM administrateur WHERE id_admin = ?;';
			$pdoLink = $this->db->prepare($sql);
			$pdoLink->execute(array($id));
		}
		
		public function getImagesFromSearch($search) {
			// Escape special chars
			$forbiddenChar = [';', '(', ')', '"', ','];
			$search = str_replace($forbiddenChar, "", $search);
			
			// Explode the query search to an array of words
			$search = explode(" ",$search);
			
			// Database call
			$sql = 'SELECT DISTINCT I.id_image, I.filename, I.titre, I.dateCreation, I.datePriseDeVue,
				I.PrixHT, I.camera, I.longueurFocale, I.ouverture, I.tpsExpo, I.sensibiliteISO,
  				I.clefAcces, I.visibilite, I.id_collection, I.id_photographe, I.id_theme, I.auteur
				FROM image I, tag T, posseder IT WHERE I.id_image=IT.id_image AND IT.id_tag=T.id_tag ';
			$sql .= " AND (T.label LIKE '%".$search['0']."%'";
			$sql .= " OR I.titre LIKE '%".array_shift($search)."%'";
			foreach ($search as $word) {
				$sql .= " OR T.label LIKE '%".$word."%'";
				$sql .= " OR I.titre LIKE '%".$word."%'";
			}
			$sql .= ");";
			return $this->getImages($sql);
			
			/*
			$sqlArgs = $search;
			$j = 0;
			for($i = 0; $i < count($search); $i++) {
				$sqlArgs[$j] = $search[$i];
				$sqlArgs[$j+1] = $search[$i];
				$j += 2;
			}
			$sql = 'SELECT I.id_image, I.filename, I.titre, I.dateCreation, I.datePriseDeVue,
				I.PrixHT, I.camera, I.longueurFocale, I.ouverture, I.tpsExpo, I.sensibiliteISO,
  				I.clefAcces, I.visibilite, I.id_collection, I.id_photographe, I.id_theme, I.auteur
				FROM image I, tag T, posseder IT WHERE I.id_image=IT.id_image AND IT.id_tag=T.id_tag ';
			$sql .= " AND (T.label LIKE '% ? %'";
			$sql .= " OR I.titre LIKE '% ? %'";
			for ($i = 0; $i < count($search)-1; $i++) {
				$sql .= " OR T.label LIKE '% ? %'";
				$sql .= " OR I.titre LIKE '% ? %'";
			}
			$sql .= ");";
			
			print_r($sql);
			
			$statement = $this->db->prepare($sql);
			$statement->execute($sqlArgs);
			
			return $statement->fetchAll();
			*/
  		}
  		
  		public function getImages($sql) {
			if($statement = $this->db->query($sql)) {
				return $statement->fetchAll();
			} else {
				return array();
			}
		}
		
		public function getImageById($id) {
			$sql = 'SELECT I.id_image, I.filename, I.titre, I.dateCreation, I.datePriseDeVue,
				I.prixHT, I.camera, I.longueurFocale, I.ouverture, I.tpsExpo, I.sensibiliteISO,
  				I.clefAcces, I.visibilite, I.id_collection, I.id_photographe, I.id_theme, I.auteur
				FROM image I WHERE I.id_image= ? ;';
			$statement = $this->db->prepare($sql);
			$statement->execute(array($id));
			$res = $statement->fetchAll();
			if(is_array($res) && count($res) > 0) {
				return $res[0];
			} else {
				return array();
			}
		}
		
		public function getImageTagsById($id) {
			$sql = 'SELECT T.id_tag, T.label FROM tag T, posseder IT
				WHERE T.id_tag = IT.id_tag AND IT.id_image= ? ;';
			$statement = $this->db->prepare($sql);
			$statement->execute(array($id));
			$res = $statement->fetchAll();
			if(is_array($res) && count($res) > 0) {
				return $res;
			} else {
				return array();
			}
		}
		
		public function getImageColorsById($id) {
			$sql = 'SELECT C.hexcode FROM comporter C
				WHERE C.id_image= ? ;';
			$statement = $this->db->prepare($sql);
			$statement->execute(array($id));
			$res = $statement->fetchAll();
			if(is_array($res) && count($res) > 0) {
				return $res;
			} else {
				return array();
			}
		}
	}
