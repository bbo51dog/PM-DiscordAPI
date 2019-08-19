<?php

/**
 * _     _                             ____  _ 
 *| |__ | |__   ___  _   _ _   _ _   _| ___|/ |
 *| '_ \| '_ \ / _ \| | | | | | | | | |___ \| |
 *| |_) | |_) | (_) | |_| | |_| | |_| |___) | |
 *|_.__/|_.__/ \___/ \__, |\__, |\__,_|____/|_|
 *                   |___/ |___/     
 *           
 * Send Message to Discord API
 * 
 * @license https://opensource.org/licenses/mit-license.html MIT License
 * @see https://github.com/bboyyu51/PM-DiscordAPI
 * @author bboyyu51 <bbo51@icloud.com>
 * @copyright 2019 bboyyu51
 */

declare(strict_types = 1);

namespace bboyyu51\pmdiscord;

use pocketmine\Server;
use bboyyu51\pmdiscord\connect\Webhook;

class Sender{
    
    /**
     * Send Message to Discord
     *
     * @param Webhook $webhook
     */
    public static function send(Webhook $webhook): void{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhook->getUrl());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook->getData()));
        curl_exec($ch);
        curl_close($ch);
    }
    
    /**
     * Send Message by AsyncTask
     *
     * @param Webhook $webhook
     */
    public static function sendAsync(Webhook $webhook): void{
        Server::getInstance()->getAsyncPool()->submitTask(new AsyncSendTask($webhook));
    }
    
    /**
     * Create Webhook instance
     * 
     * @param string $webhook_url
     * @return Webhook
     */
    public static function create(string $webhook_url): Webhook{
        return new Webhook($webhook_url);
    }
}