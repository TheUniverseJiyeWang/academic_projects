//
//  MainTableViewCell.swift
//  assignment02_A00426401
//
//  Created by jiye wang on 2019-07-26.
//  Copyright © 2019 jiye wang. All rights reserved.
//

import UIKit

class MainTableViewCell: UITableViewCell {


    @IBOutlet weak var Label01: UILabel!
    @IBOutlet weak var icon: UIImageView!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
