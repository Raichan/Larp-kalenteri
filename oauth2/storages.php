<?php

require_once __DIR__ . '/../dat/connectDB.php';
require __DIR__ . '/../vendor/autoload.php';

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Storage\ClientInterface;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Entity\AbstractTokenEntity;
use League\OAuth2\Server\Storage\SessionInterface;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\ScopeInterface;
use League\OAuth2\Server\Storage\AbstractStorage;

class ClientStorage extends AbstractStorage implements ClientInterface {
	
	public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null) {
		$result = dbQueryP("select name, client_id, client_secret from oauth_clients where client_id = $1 and client_secret = $2", [ $clientId, $clientSecret ]);
		if ($result) {
  	  $row = pg_fetch_assoc($result);
			if ($row) {
				return (new ClientEntity($this->server))->hydrate([
					'id' => $row['client_id'],
					'secret' => $row['client_secret'],
	  			'name' => $row['name']
				]);
			}
		}

		return null;
	}
	
	public function getBySession(SessionEntity $session) {
		$result = dbQueryP("select c.client_id, c.client_secret, c.name from oauth_clients c, oauth_sessions s where s.client_id = c.id and s.session_id = $1", [ $session->getId() ]);
		
		if ($result) {
			$row = pg_fetch_assoc($result);
			if ($row) {
				return (new ClientEntity($this->server))->hydrate([
					'id' => $row['client_id'],
					'secret' => $row['client_secret'],
					'name' => $row['name']
				]);
			}
		}
		
		return null;
	}
	
}

class SessionStorage extends AbstractStorage implements SessionInterface {

	public function getByAccessToken(AccessTokenEntity $accessToken) {
		$result = dbQueryP("select session_id, owner_type, owner_id from oauth_sessions where id = (select session_id from oauth_access_tokens where access_token = $1)", [ $accessToken->getId() ]);
		
		if ($result) {
			$row = pg_fetch_assoc($result);
			if ($row) {
        $session = new SessionEntity($this->server);
        $session->setId($row['session_id']);
        $session->setOwner($row['owner_type'], $row['owner_id']);
        return $session;
		  }
		}
  }
  
  public function getByAuthCode(AuthCodeEntity $authCode) {
		$result = dbQueryP("select session_id, owner_type, owner_id from oauth_sessions where id = (select session_id from oauth_auth_codes where auth_code = $1)", [ $authCode->getId() ]);
    if ($result) {
      $row = pg_fetch_assoc($result);
    	if ($row) {
    	  $session = new SessionEntity($this->server);
    		$session->setId($row['session_id']);
    		$session->setOwner($row['owner_type'], $row['owner_id']);
    		return $session;
      }
    }	
  }

  public function getScopes(SessionEntity $session) {
    return [];
  }

  public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null) {
  	$sessionId = uniqid();
		dbQueryP("insert into oauth_sessions (session_id, owner_id, owner_type, client_id) select $1, $2, $3, id from oauth_clients where client_id = $4", [  $sessionId, $ownerId, $ownerType, $clientId ]);
		return $sessionId;
  }

  public function associateScope(SessionEntity $session, ScopeEntity $scope) {
  }
}

class AccessTokenStorage extends AbstractStorage implements AccessTokenInterface {
  
	public function get($token) {
   	$result = dbQueryP("select access_token, expire_time from oauth_access_tokens where access_token = $1", [ $token ]);
    if ($result) {
      $row = pg_fetch_assoc($result);
    	if ($row) {
    	  return (new AccessTokenEntity($this->server))
          ->setId($row['access_token'])
          ->setExpireTime($row['expire_time']);
    	}
    }
    	
    return null;
   }

   public function getScopes(AccessTokenEntity $token) {
     return [];
   }

   public function create($token, $expireTime, $sessionId) {
     dbQueryP("insert into oauth_access_tokens (access_token, expire_time, session_id) select $1, $2, id from oauth_sessions where session_id = $3", [ $token, $expireTime, $sessionId ]);
   }

   public function associateScope(AccessTokenEntity $token, ScopeEntity $scope) {
   }

   public function delete(AccessTokenEntity $token) {
     dbQueryP("delete from oauth_access_tokens where access_token = $1", [ $token->getId() ]);
   }
}

class ScopeStorage extends AbstractStorage implements ScopeInterface {
	
	public function get($scope, $grantType = null, $clientId = null) {
		return [];
	}

}

?>