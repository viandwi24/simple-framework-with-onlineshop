<?php
class Keranjang {
    public function get()
    {
        $db = new Database;

        $cart_cookie = (Cookie::get('keranjang') == null) ? [] : explode(',', Cookie::get('keranjang'));
        $cart_list = [];
        $cart_product_list = [];

        if(count($cart_cookie) == 0) return [];
        // dd($cart_cookie);
        
        foreach($cart_cookie as $item) {
            $pecah = @explode(':', $item);
            if (count($pecah) != 2) continue;
            $cart_list[$pecah[0]] = $pecah[1];
            $cart_product_list[] = $pecah[0];
        }
        
        $cart_in_product = $db->table('product')->where('id', 'IN', $cart_product_list)->get();

        $cart_with_product = [];
        $new_cart_cookie = [];
        foreach($cart_in_product as $item)
        {
            //search
            if (!isset($cart_list[$item->id])) continue;
            if($item->stock == 0) continue;

            $stock = (int) ($item->stock > $cart_list[$item->id]) ? $cart_list[$item->id] : $item->stock;
            $stock = intval($stock);

            $cart_with_product[] = (object) [
                'id' => $item->id,
                'stock' => $stock,
                'product' => $item
            ];

            $new_cart_cookie[] = $item->id . ':' . $stock;
        }

        // save new cookie
        Cookie::set('keranjang', implode(',', $new_cart_cookie));

        return $cart_with_product;
    }

    public function count()
    {
        $c = count($this->get());
        $this->pdo = null;
        return $c;
    }

    public function add($id, $stock = 1)
    {
        $cart = $this->get();
        $cart = json_decode(json_encode($cart), true);
        $search_id = array_search($id, array_column($cart, 'id'));
        if ($search_id === false) {
            $cookie = Cookie::get('keranjang');
            $save = $cookie . ',' . $id . ':' . $stock;
            Cookie::set('keranjang', $save);
            return true;
        } else {
            $cookie = Cookie::get('keranjang');
            $cookie_arr = explode(',', $cookie);
            $new_cookie = [];
            foreach($cookie_arr as $item)
            {
                $item = explode(':', $item);
                $new_cookie[$item[0]] = $item[1];
            }

            // add new
            $new_cookie[$id] = $new_cookie[$id]+$stock;

            $cookie_arr = [];
            foreach($new_cookie as $item_k => $item)
            {
                $cookie_arr[] = $item_k . ':' . $item;
            }
            $cookie_arr = implode(',', $cookie_arr);
            Cookie::set('keranjang', $cookie_arr);
            return true;
        }
    }

    public function change($id, $stock)
    {
        $cart = $this->get();
        $cart = json_decode(json_encode($cart), true);
        $search_id = array_search($id, array_column($cart, 'id'));
        if ($search_id !== false) {
            $cookie = Cookie::get('keranjang');
            $cookie_arr = explode(',', $cookie);
            $new_cookie = [];
            foreach($cookie_arr as $item)
            {
                $item = explode(':', $item);
                $new_cookie[$item[0]] = $item[1];
            }

            // add new
            $new_cookie[$id] = $stock;

            $cookie_arr = [];
            foreach($new_cookie as $item_k => $item)
            {
                $cookie_arr[] = $item_k . ':' . $item;
            }
            $cookie_arr = implode(',', $cookie_arr);
            Cookie::set('keranjang', $cookie_arr);
            return true;
        }

        return false;
    }





    public function delete($id)
    {
        $cart = $this->get();
        $cart = json_decode(json_encode($cart), true);
        $search_id = array_search($id, array_column($cart, 'id'));
        if ($search_id !== false) {
            $cookie = Cookie::get('keranjang');
            $cookie_arr = explode(',', $cookie);
            $new_cookie = [];
            foreach($cookie_arr as $item)
            {
                $item = explode(':', $item);
                $new_cookie[$item[0]] = $item[1];
            }

            // del
            unset($new_cookie[$id]);

            $cookie_arr = [];
            foreach($new_cookie as $item_k => $item)
            {
                $cookie_arr[] = $item_k . ':' . $item;
            }
            $cookie_arr = implode(',', $cookie_arr);
            Cookie::set('keranjang', $cookie_arr);
            return true;
        }

        return false;
    }
}