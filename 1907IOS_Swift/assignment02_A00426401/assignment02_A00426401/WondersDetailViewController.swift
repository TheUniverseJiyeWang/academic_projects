//
//  WondersDetailViewController.swift
//  assignment02_A00426401
//
//  Created by jiye wang on 2019-07-26.
//  Copyright © 2019 jiye wang. All rights reserved.
//

import UIKit

class WondersDetailViewController: UIViewController {

    @IBOutlet weak var img: UIImageView!
    @IBOutlet weak var lbl: UILabel!
    @IBOutlet weak var des: UILabel!
    @IBOutlet weak var user: UILabel!
    @IBOutlet weak var urlshow: UILabel!
    
    var image = UIImage()
    var name = ""
    var descrip = ""
    var userR = ""
    var imgstring = ""

    
    override func viewDidLoad() {
        super.viewDidLoad()
        lbl.text = name
        des.text = descrip
        user.text = userR
        let imgurl = URL(string: imgstring)
//        let imgurl = NSURL(string: imgstring)
        downloaded(from: imgurl!)
        urlshow.text = imgstring
//        img.image = image
        // Do any additional setup after loading the view.
    }
//
    func downloaded(from url: URL, contentMode mode: UIView.ContentMode = .scaleAspectFit) {  // for swift 4.2 syntax just use ===> mode: UIView.ContentMode
//        contentMode = mode
        print("start")
        URLSession.shared.dataTask(with: url) { data, response, error in
            guard
                let httpURLResponse = response as? HTTPURLResponse, httpURLResponse.statusCode == 200,
                let mimeType = response?.mimeType, mimeType.hasPrefix("image"),
                let data = data, error == nil,
                let image = UIImage(data: data)
                else {
                    print("error")
                    return }
            DispatchQueue.main.async() {
                print("image")
                self.img.image = image
            }
            }.resume()
    }
    
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
